import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../constants/app_colors.dart';
import '../../constants/app_routes.dart';
import '../../providers/language_provider.dart';
import '../../widgets/azam_logo.dart';

class OnboardingScreen extends ConsumerStatefulWidget {
  const OnboardingScreen({super.key});

  @override
  ConsumerState<OnboardingScreen> createState() => _OnboardingScreenState();
}

class _OnboardingScreenState extends ConsumerState<OnboardingScreen> {
  final PageController _pageController = PageController();
  int _currentPage = 0;
  String _selectedLanguage = 'sw'; // Default to Swahili

  final List<OnboardingPage> _pages = [
    OnboardingPage(
      title: 'Karibu Azam FC',
      subtitle: 'Welcome to Azam FC',
      description: 'Jiunge na timu yetu ya soka na uweze kufuatilia habari zote za Azam FC',
      descriptionEn: 'Join our football team and stay updated with all Azam FC news',
      icon: Icons.sports_soccer,
      color: AppColors.primaryBlue,
    ),
    OnboardingPage(
      title: 'Habari za Soka',
      subtitle: 'Football News',
      description: 'Pata habari za hivi karibuni, matokeo ya mechi, na uchambuzi wa timu',
      descriptionEn: 'Get the latest news, match results, and team analysis',
      icon: Icons.newspaper,
      color: AppColors.secondaryGreen,
    ),
    OnboardingPage(
      title: 'Ratiba ya Michuano',
      subtitle: 'Match Fixtures',
      description: 'Fuatilia ratiba ya mechi zetu na upate taarifa za michezo ijayo',
      descriptionEn: 'Track our match schedule and get information about upcoming games',
      icon: Icons.calendar_today,
      color: AppColors.secondaryRed,
    ),
    OnboardingPage(
      title: 'Wachezaji Wetu',
      subtitle: 'Our Players',
      description: 'Jifahamishe na wachezaji wetu na uone takwimu zao za michezo',
      descriptionEn: 'Get to know our players and see their game statistics',
      icon: Icons.people,
      color: AppColors.secondaryGold,
    ),
  ];

  @override
  void dispose() {
    _pageController.dispose();
    super.dispose();
  }

  void _nextPage() {
    if (_currentPage < _pages.length - 1) {
      _pageController.nextPage(
        duration: const Duration(milliseconds: 300),
        curve: Curves.easeInOut,
      );
    } else {
      _completeOnboarding();
    }
  }

  void _previousPage() {
    if (_currentPage > 0) {
      _pageController.previousPage(
        duration: const Duration(milliseconds: 300),
        curve: Curves.easeInOut,
      );
    }
  }

  void _completeOnboarding() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool('isFirstLaunch', false);
    await prefs.setString('language', _selectedLanguage);
    
    if (mounted) {
      // Set language in provider
      ref.read(languageProviderProvider.notifier).setLanguage(_selectedLanguage);
      
      // Navigate to login screen
      context.go(AppRoutes.login);
    }
  }

  @override
  Widget build(BuildContext context) {
    final isLastPage = _currentPage == _pages.length - 1;
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: SafeArea(
        child: Column(
          children: [
            // Header with logo and skip button
            Padding(
              padding: const EdgeInsets.all(24),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const AzamLogo(size: 40),
                  Row(
                    children: [
                      TextButton(
                        onPressed: () {
                          context.go(AppRoutes.main);
                        },
                        child: Text(
                          'Skip',
                          style: Theme.of(context).textTheme.titleMedium?.copyWith(
                            color: AppColors.primaryBlue,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ),
                      const SizedBox(width: 16),
                      Text(
                        '${_currentPage + 1}/${_pages.length}',
                        style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          color: AppColors.textSecondary,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
            
            // Page content
            Expanded(
              child: PageView.builder(
                controller: _pageController,
                onPageChanged: (index) {
                  setState(() {
                    _currentPage = index;
                  });
                },
                itemCount: _pages.length,
                itemBuilder: (context, index) {
                  final page = _pages[index];
                  return _buildPage(page, index);
                },
              ),
            ),
            
            // Language selection (only on last page)
            if (isLastPage) ...[
              _buildLanguageSelection(),
              const SizedBox(height: 24),
            ],
            
            // Navigation buttons
            Padding(
              padding: const EdgeInsets.all(24),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  // Previous button
                  if (_currentPage > 0)
                    TextButton(
                      onPressed: _previousPage,
                      child: Text(
                        'Nyuma',
                        style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          color: AppColors.primaryBlue,
                        ),
                      ),
                    )
                  else
                    const SizedBox(width: 80),
                  
                  // Page indicators
                  Row(
                    children: List.generate(
                      _pages.length,
                      (index) => Container(
                        margin: const EdgeInsets.symmetric(horizontal: 4),
                        width: 8,
                        height: 8,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          color: index == _currentPage
                              ? AppColors.primaryBlue
                              : AppColors.borderColor,
                        ),
                      ),
                    ),
                  ),
                  
                  // Next/Complete button
                  ElevatedButton(
                    onPressed: _nextPage,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: _pages[_currentPage].color,
                      padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 16),
                    ),
                    child: Text(
                      isLastPage ? 'Endelea' : 'Ifuatayo',
                      style: Theme.of(context).textTheme.titleMedium?.copyWith(
                        color: AppColors.white,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildPage(OnboardingPage page, int index) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 32),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          // Icon
          Container(
            width: 120,
            height: 120,
            decoration: BoxDecoration(
              color: page.color.withOpacity(0.1),
              shape: BoxShape.circle,
            ),
            child: Icon(
              page.icon,
              size: 60,
              color: page.color,
            ),
          ).animate().scale(
            duration: const Duration(milliseconds: 600),
            curve: Curves.elasticOut,
          ),
          
          const SizedBox(height: 48),
          
          // Title
          Text(
            page.title,
            style: Theme.of(context).textTheme.headlineMedium?.copyWith(
              color: page.color,
              fontWeight: FontWeight.w700,
            ),
            textAlign: TextAlign.center,
          ).animate().fadeIn(
            duration: const Duration(milliseconds: 600),
            delay: const Duration(milliseconds: 200),
          ),
          
          const SizedBox(height: 16),
          
          // Subtitle
          Text(
            page.subtitle,
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
              color: AppColors.textSecondary,
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ).animate().fadeIn(
            duration: const Duration(milliseconds: 600),
            delay: const Duration(milliseconds: 400),
          ),
          
          const SizedBox(height: 24),
          
          // Description
          Text(
            _selectedLanguage == 'sw' ? page.description : page.descriptionEn,
            style: Theme.of(context).textTheme.bodyLarge?.copyWith(
              color: AppColors.textSecondary,
              height: 1.5,
            ),
            textAlign: TextAlign.center,
          ).animate().fadeIn(
            duration: const Duration(milliseconds: 600),
            delay: const Duration(milliseconds: 600),
          ),
        ],
      ),
    );
  }

  Widget _buildLanguageSelection() {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 32),
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: AppColors.cardBackground,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: AppColors.shadowColor,
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Column(
        children: [
          Text(
            'Chagua Lugha / Select Language',
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
              fontWeight: FontWeight.w600,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 24),
          Row(
            children: [
              Expanded(
                child: _buildLanguageButton(
                  'sw',
                  'SWAHILI',
                  _selectedLanguage == 'sw',
                  AppColors.primaryBlue,
                ),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: _buildLanguageButton(
                  'en',
                  'ENGLISH',
                  _selectedLanguage == 'en',
                  AppColors.primaryBlue,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildLanguageButton(String language, String label, bool isSelected, Color color) {
    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedLanguage = language;
        });
      },
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 16),
        decoration: BoxDecoration(
          color: isSelected ? color : AppColors.surfaceBackground,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: isSelected ? color : AppColors.borderColor,
            width: 2,
          ),
        ),
        child: Text(
          label,
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            color: isSelected ? AppColors.white : AppColors.textPrimary,
            fontWeight: FontWeight.w600,
          ),
          textAlign: TextAlign.center,
        ),
      ),
    );
  }
}

class OnboardingPage {
  final String title;
  final String subtitle;
  final String description;
  final String descriptionEn;
  final IconData icon;
  final Color color;

  OnboardingPage({
    required this.title,
    required this.subtitle,
    required this.description,
    required this.descriptionEn,
    required this.icon,
    required this.color,
  });
}
