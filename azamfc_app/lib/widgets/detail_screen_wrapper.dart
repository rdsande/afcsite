import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';

import '../constants/app_colors.dart';
import '../constants/app_routes.dart';
import '../providers/language_provider.dart';
import '../widgets/azam_logo.dart';
import '../screens/players/players_screen.dart';
import '../screens/search/search_screen.dart';

class DetailScreenWrapper extends ConsumerStatefulWidget {
  final Widget child;
  final String title;
  final String? titleSw; // Swahili title
  
  const DetailScreenWrapper({
    super.key,
    required this.child,
    required this.title,
    this.titleSw,
  });

  @override
  ConsumerState<DetailScreenWrapper> createState() => _DetailScreenWrapperState();
}

class _DetailScreenWrapperState extends ConsumerState<DetailScreenWrapper> {
  int _currentIndex = 0; // Default to home for navigation context

  final List<BottomNavItem> _bottomNavItems = [
    BottomNavItem(
      icon: Icons.home_outlined,
      activeIcon: Icons.home,
      label: 'Nyumbani',
      labelEn: 'Home',
      route: '/main',
    ),
    BottomNavItem(
      icon: Icons.newspaper_outlined,
      activeIcon: Icons.newspaper,
      label: 'Habari',
      labelEn: 'News',
      route: '/main', // Will navigate to main screen with news tab
    ),
    BottomNavItem(
      icon: Icons.sports_soccer_outlined,
      activeIcon: Icons.sports_soccer,
      label: 'Michuano',
      labelEn: 'Fixtures',
      route: '/main', // Will navigate to main screen with fixtures tab
    ),
    BottomNavItem(
      icon: Icons.shopping_bag_outlined,
      activeIcon: Icons.shopping_bag,
      label: 'Duka',
      labelEn: 'Shop',
      route: '/main', // Will navigate to main screen with shop tab
    ),
    BottomNavItem(
      icon: Icons.person_outline,
      activeIcon: Icons.person,
      label: 'Akaunti',
      labelEn: 'Account',
      route: '/main', // Will navigate to main screen with account tab
    ),
  ];

  void _onTabTapped(int index) {
    // Navigate back to main screen
    context.go('/main');
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    final displayTitle = isEnglish ? widget.title : (widget.titleSw ?? widget.title);
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: Column(
        children: [
          // Custom App Bar
          _buildCustomAppBar(context, isEnglish, displayTitle),
          
          // Page Content
          Expanded(
            child: widget.child,
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

  Widget _buildCustomAppBar(BuildContext context, bool isEnglish, String title) {
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
      child: SafeArea(
        child: Row(
          children: [
            // Back button
            IconButton(
              onPressed: () {
                if (Navigator.canPop(context)) {
                  Navigator.pop(context);
                } else {
                  context.go('/main');
                }
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
            
            // Centered Logo and Title
            Expanded(
              child: Column(
                children: [
                  const AzamLogo(size: 28),
                  const SizedBox(height: 4),
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                      color: AppColors.textPrimary,
                    ),
                    textAlign: TextAlign.center,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ],
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
            
            // Home button
            IconButton(
              onPressed: () {
                context.go('/main');
              },
              icon: const Icon(
                Icons.home_outlined,
                color: AppColors.textPrimary,
                size: 24,
              ),
            ),
          ],
        ),
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
  final String route;

  BottomNavItem({
    required this.icon,
    required this.activeIcon,
    required this.label,
    required this.labelEn,
    required this.route,
  });
}