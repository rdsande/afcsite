import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../../constants/app_colors.dart';
import '../../providers/language_provider.dart';
import '../../providers/auth_provider.dart';
import '../../providers/theme_provider.dart';
import '../../constants/app_routes.dart';

class AccountScreen extends ConsumerWidget {
  const AccountScreen({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    final authState = ref.watch(authProviderProvider);
    
    // Temporarily bypass authentication check to show demo account
    if (false) { // Changed from (!authState.isAuthenticated || authState.fan == null)
      return Scaffold(
        backgroundColor: AppColors.backgroundColor,
        body: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.person_off,
                size: 64,
                color: AppColors.textSecondary,
              ),
              const SizedBox(height: 16),
              Text(
                isEnglish ? 'Please log in to view your account' : 'Tafadhali ingia ili kuona akaunti yako',
                style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                  color: AppColors.textSecondary,
                ),
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 24),
              ElevatedButton(
                onPressed: () {
                  Navigator.pushNamed(context, AppRoutes.login);
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: AppColors.primaryBlue,
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 12),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8),
                  ),
                ),
                child: Text(
                  isEnglish ? 'Log In' : 'Ingia',
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ],
          ),
        ),
      );
    }

    // Use demo data instead of actual fan data
    final fan = {
      'name': 'Demo Fan',
      'phone': '+255 712 345 678',
      'email': 'demo@azamfc.com',
      'region': 'Dar es Salaam',
      'district': 'Kinondoni',
      'profileImage': null,
    };
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Header
              Text(
                isEnglish ? 'My Account' : 'Akaunti Yangu',
                style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                  color: AppColors.primaryBlue,
                  fontWeight: FontWeight.w700,
                ),
              ),
              const SizedBox(height: 32),
              
              // Profile Section
              _buildProfileSection(context, fan, isEnglish),
              const SizedBox(height: 32),
              
              // Account Information
              _buildAccountInfo(context, fan, isEnglish),
              const SizedBox(height: 32),
              
              // Settings Section
              _buildSettingsSection(context, ref, isEnglish),
              const SizedBox(height: 32),
              
              // Logout Button
              _buildLogoutButton(context, ref, isEnglish),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildProfileSection(BuildContext context, fan, bool isEnglish) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: AppColors.cardBackground,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          // Profile Image
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: AppColors.primaryBlue.withOpacity(0.1),
            ),
            child: fan['profileImage'] != null
                ? ClipOval(
                    child: CachedNetworkImage(
                      imageUrl: fan['profileImage']!,
                      fit: BoxFit.cover,
                      placeholder: (context, url) => const CircularProgressIndicator(),
                      errorWidget: (context, url, error) => Icon(
                        Icons.person,
                        size: 40,
                        color: AppColors.primaryBlue,
                      ),
                    ),
                  )
                : Icon(
                    Icons.person,
                    size: 40,
                    color: AppColors.primaryBlue,
                  ),
          ),
          const SizedBox(width: 16),
          
          // Profile Info
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  fan['name'],
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    color: AppColors.textPrimary,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  fan['email'],
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.textSecondary,
                  ),
                ),
                const SizedBox(height: 4),
                Row(
                  children: [
                    Icon(
                      Icons.location_on,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      '${fan['region']}, ${fan['district']}',
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
          
          // Points Badge
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: AppColors.secondaryGold,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(
                  Icons.star,
                  size: 16,
                  color: Colors.white,
                ),
                const SizedBox(width: 4),
                Text(
                  '1250', // Demo points
                  style: const TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.w600,
                    fontSize: 12,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAccountInfo(BuildContext context, fan, bool isEnglish) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: AppColors.cardBackground,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            isEnglish ? 'Account Information' : 'Taarifa za Akaunti',
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppColors.textPrimary,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 16),
          
          _buildInfoRow(
            context,
            Icons.phone,
            isEnglish ? 'Phone' : 'Simu',
            fan['phone'],
          ),
          
          _buildInfoRow(
            context,
            Icons.cake,
            isEnglish ? 'Date of Birth' : 'Tarehe ya Kuzaliwa',
            '15/06/1995', // Demo date
          ),
          
          _buildInfoRow(
            context,
            Icons.person,
            isEnglish ? 'Age' : 'Umri',
            '28 ${isEnglish ? 'years' : 'miaka'}', // Demo age
          ),
          
          _buildInfoRow(
            context,
            Icons.wc,
            isEnglish ? 'Gender' : 'Jinsia',
            isEnglish ? 'Male' : 'Mwanaume', // Demo gender
          ),
          
          _buildInfoRow(
            context,
            Icons.calendar_today,
            isEnglish ? 'Member Since' : 'Mwanachama Tangu',
            '01/01/2023', // Demo join date
          ),
        ],
      ),
    );
  }

  Widget _buildInfoRow(BuildContext context, IconData icon, String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        children: [
          Icon(
            icon,
            size: 20,
            color: AppColors.primaryBlue,
          ),
          const SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: Theme.of(context).textTheme.bodySmall?.copyWith(
                    color: AppColors.textSecondary,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const SizedBox(height: 2),
                Text(
                  value,
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.textPrimary,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSettingsSection(BuildContext context, WidgetRef ref, bool isEnglish) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: AppColors.cardBackground,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            isEnglish ? 'Settings' : 'Mipangilio',
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppColors.textPrimary,
              fontWeight: FontWeight.w600,
            ),
          ),
          const SizedBox(height: 16),
          
          // Language Toggle
          _buildSettingRow(
            context,
            Icons.language,
            isEnglish ? 'Language' : 'Lugha',
            isEnglish ? 'English' : 'Kiswahili',
            () {
              ref.read(languageProviderProvider.notifier).toggleLanguage();
            },
          ),
          
          // Blue Theme Toggle
          _buildBlueThemeRow(context, ref, isEnglish),
          
          _buildSettingRow(
            context,
            Icons.notifications,
            isEnglish ? 'Notifications' : 'Arifa',
            isEnglish ? 'Enabled' : 'Zimewashwa',
            () {
              // TODO: Implement notification settings
            },
          ),
          
          _buildSettingRow(
            context,
            Icons.privacy_tip,
            isEnglish ? 'Privacy' : 'Faragha',
            '',
            () {
              // TODO: Implement privacy settings
            },
          ),
          
          _buildSettingRow(
            context,
            Icons.help,
            isEnglish ? 'Help & Support' : 'Msaada',
            '',
            () {
              // TODO: Implement help & support
            },
          ),
        ],
      ),
    );
  }

  Widget _buildSettingRow(BuildContext context, IconData icon, String title, String subtitle, VoidCallback onTap) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(8),
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 8),
        child: Row(
          children: [
            Icon(
              icon,
              size: 20,
              color: AppColors.primaryBlue,
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                      color: AppColors.textPrimary,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  if (subtitle.isNotEmpty) ...[
                    const SizedBox(height: 2),
                    Text(
                      subtitle,
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                  ],
                ],
              ),
            ),
            Icon(
              Icons.chevron_right,
              size: 20,
              color: AppColors.textSecondary,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildBlueThemeRow(BuildContext context, WidgetRef ref, bool isEnglish) {
    final blueTheme = ref.watch(blueThemeProvider);
    final isLightBlue = blueTheme == BlueTheme.lightBlue;
    
    return InkWell(
      onTap: () {
        ref.read(blueThemeProvider.notifier).toggleBlueTheme();
      },
      borderRadius: BorderRadius.circular(8),
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 12),
        child: Row(
          children: [
            Icon(
              Icons.palette,
              size: 20,
              color: BlueThemeColors.getPrimaryColor(blueTheme),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    isEnglish ? 'Blue Theme' : 'Mandhari ya Bluu',
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                      color: AppColors.textPrimary,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    isLightBlue 
                        ? (isEnglish ? 'Light Blue' : 'Bluu Nyepesi')
                        : (isEnglish ? 'Dark Blue' : 'Bluu Nzito'),
                    style: Theme.of(context).textTheme.bodySmall?.copyWith(
                      color: AppColors.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
            Container(
              width: 50,
              height: 30,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(15),
                color: isLightBlue 
                    ? BlueThemeColors.lightBlue.withOpacity(0.2)
                    : BlueThemeColors.darkBlue.withOpacity(0.2),
                boxShadow: BlueThemeColors.getCreativeShadows(blueTheme),
              ),
              child: Stack(
                children: [
                  AnimatedPositioned(
                    duration: const Duration(milliseconds: 200),
                    left: isLightBlue ? 2 : 22,
                    top: 2,
                    child: Container(
                      width: 26,
                      height: 26,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        color: BlueThemeColors.getPrimaryColor(blueTheme),
                        boxShadow: [
                          BoxShadow(
                            color: BlueThemeColors.getShadowColor(blueTheme),
                            blurRadius: 8,
                            offset: const Offset(0, 2),
                          ),
                        ],
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

  Widget _buildLogoutButton(BuildContext context, WidgetRef ref, bool isEnglish) {
    return SizedBox(
      width: double.infinity,
      child: ElevatedButton(
        onPressed: () async {
          // Show confirmation dialog
          final shouldLogout = await showDialog<bool>(
            context: context,
            builder: (context) => AlertDialog(
              title: Text(
                isEnglish ? 'Logout' : 'Toka',
                style: TextStyle(color: AppColors.textPrimary),
              ),
              content: Text(
                isEnglish ? 'Are you sure you want to logout?' : 'Una uhakika unataka kutoka?',
                style: TextStyle(color: AppColors.textSecondary),
              ),
              backgroundColor: AppColors.cardBackground,
              actions: [
                TextButton(
                  onPressed: () => Navigator.of(context).pop(false),
                  child: Text(
                    isEnglish ? 'Cancel' : 'Ghairi',
                    style: TextStyle(color: AppColors.textSecondary),
                  ),
                ),
                TextButton(
                  onPressed: () => Navigator.of(context).pop(true),
                  child: Text(
                    isEnglish ? 'Logout' : 'Toka',
                    style: TextStyle(color: AppColors.primaryBlue),
                  ),
                ),
              ],
            ),
          );
          
          if (shouldLogout == true) {
            await ref.read(authProviderProvider.notifier).logout();
            if (context.mounted) {
              Navigator.pushReplacementNamed(context, AppRoutes.login);
            }
          }
        },
        style: ElevatedButton.styleFrom(
          backgroundColor: Colors.red.shade600,
          foregroundColor: Colors.white,
          padding: const EdgeInsets.symmetric(vertical: 16),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.logout, size: 20),
            const SizedBox(width: 8),
            Text(
              isEnglish ? 'Logout' : 'Toka',
              style: const TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
