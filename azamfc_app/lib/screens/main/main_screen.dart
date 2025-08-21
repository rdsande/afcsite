import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../constants/app_colors.dart';
import '../../constants/app_routes.dart';
import '../../providers/auth_provider.dart';
import '../../providers/language_provider.dart';
import '../../widgets/azam_logo.dart';
import '../home/home_screen.dart';
import '../news/news_screen.dart';
import '../fixtures/fixtures_screen.dart';
import '../shop/shop_screen.dart';
import '../account/account_screen.dart';
import '../players/players_screen.dart';
import '../search/search_screen.dart';

class MainScreen extends ConsumerStatefulWidget {
  const MainScreen({super.key});

  @override
  ConsumerState<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends ConsumerState<MainScreen> {
  int _currentIndex = 0;
  final PageController _pageController = PageController();

  final List<Widget> _pages = [
    const HomeScreen(),
    const NewsScreen(),
    const FixturesScreen(),
    const ShopScreen(),
    const AccountScreen(),
  ];

  final List<BottomNavItem> _bottomNavItems = [
    BottomNavItem(
      icon: Icons.home_outlined,
      activeIcon: Icons.home,
      label: 'Nyumbani',
      labelEn: 'Home',
    ),
    BottomNavItem(
      icon: Icons.newspaper_outlined,
      activeIcon: Icons.newspaper,
      label: 'Habari',
      labelEn: 'News',
    ),
    BottomNavItem(
      icon: Icons.sports_soccer_outlined,
      activeIcon: Icons.sports_soccer,
      label: 'Michuano',
      labelEn: 'Fixtures',
    ),
    BottomNavItem(
      icon: Icons.shopping_bag_outlined,
      activeIcon: Icons.shopping_bag,
      label: 'Duka',
      labelEn: 'Shop',
    ),
    BottomNavItem(
      icon: Icons.person_outline,
      activeIcon: Icons.person,
      label: 'Akaunti',
      labelEn: 'Account',
    ),
  ];

  @override
  void dispose() {
    _pageController.dispose();
    super.dispose();
  }

  void _onTabTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
    _pageController.animateToPage(
      index,
      duration: const Duration(milliseconds: 300),
      curve: Curves.easeInOut,
    );
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: Column(
        children: [
          // Custom App Bar
          _buildCustomAppBar(context, isEnglish),
          
          // Page Content
          Expanded(
            child: PageView(
              controller: _pageController,
              onPageChanged: (index) {
                setState(() {
                  _currentIndex = index;
                });
              },
              children: _pages,
            ),
          ),
        ],
      ),
      
      // Bottom Navigation
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          color: AppColors.white,
          boxShadow: [
            BoxShadow(
              color: AppColors.shadowColor,
              blurRadius: 20,
              offset: const Offset(0, -5),
            ),
          ],
        ),
        child: SafeArea(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: _bottomNavItems.asMap().entries.map((entry) {
                final index = entry.key;
                final item = entry.value;
                final isSelected = index == _currentIndex;
                
                return _buildBottomNavItem(
                  item,
                  index,
                  isSelected,
                  isEnglish,
                );
              }).toList(),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildCustomAppBar(BuildContext context, bool isEnglish) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      decoration: BoxDecoration(
        color: AppColors.white,
        boxShadow: [
          BoxShadow(
            color: AppColors.shadowColorLight,
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          // Back button (if needed)
          IconButton(
            onPressed: () {
              // Handle back navigation if needed
            },
            icon: const Icon(
              Icons.arrow_back_ios,
              color: AppColors.textPrimary,
              size: 20,
            ),
          ),
          
          // Players button
          IconButton(
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const PlayersScreen(),
                ),
              );
            },
            icon: const Icon(
              Icons.people_outline,
              color: AppColors.textPrimary,
              size: 24,
            ),
          ),
          
          // Centered Logo
          Expanded(
            child: Center(
              child: const AzamLogo(size: 32),
            ),
          ),
          
          // Search button
          IconButton(
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => const SearchScreen(),
                ),
              );
            },
            icon: const Icon(
              Icons.search,
              color: AppColors.textPrimary,
              size: 24,
            ),
          ),
          
          // Account button
          IconButton(
            onPressed: () {
              // Navigate to account or show account menu
              setState(() {
                _currentIndex = 4; // Account tab
              });
              _pageController.animateToPage(
                4,
                duration: const Duration(milliseconds: 300),
                curve: Curves.easeInOut,
              );
            },
            icon: const Icon(
              Icons.account_circle_outlined,
              color: AppColors.textPrimary,
              size: 24,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBottomNavItem(
    BottomNavItem item,
    int index,
    bool isSelected,
    bool isEnglish,
  ) {
    return GestureDetector(
      onTap: () => _onTabTapped(index),
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 12),
        decoration: BoxDecoration(
          color: isSelected ? AppColors.primaryBlue.withOpacity(0.1) : Colors.transparent,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(
              isSelected ? item.activeIcon : item.icon,
              color: isSelected ? AppColors.primaryBlue : AppColors.textLight,
              size: 24,
            ),
            const SizedBox(height: 4),
            Text(
              isEnglish ? item.labelEn : item.label,
              style: TextStyle(
                color: isSelected ? AppColors.primaryBlue : AppColors.textLight,
                fontSize: 10,
                fontWeight: isSelected ? FontWeight.w600 : FontWeight.w400,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class BottomNavItem {
  final IconData icon;
  final IconData activeIcon;
  final String label;
  final String labelEn;

  BottomNavItem({
    required this.icon,
    required this.activeIcon,
    required this.label,
    required this.labelEn,
  });
}
