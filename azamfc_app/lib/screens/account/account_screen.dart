import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:go_router/go_router.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../constants/app_colors.dart';
import '../../providers/language_provider.dart';
import '../../providers/auth_provider.dart';
import '../../providers/theme_provider.dart';
import '../../constants/app_routes.dart';
import '../../services/api_service.dart';

class AccountScreen extends ConsumerStatefulWidget {
  const AccountScreen({super.key});

  @override
  ConsumerState<AccountScreen> createState() => _AccountScreenState();
}

class _AccountScreenState extends ConsumerState<AccountScreen> {
  final ApiService _apiService = ApiService();
  Map<String, dynamic>? _fanPoints;
  List<Map<String, dynamic>> _adminNotices = [];
  Map<String, dynamic>? _fanJersey;
  Map<String, dynamic>? _jerseyTypes;
  List<Map<String, dynamic>> _availableJerseys = [];
  bool _isLoadingPoints = true;
  bool _isLoadingNotices = true;
  bool _isLoadingJersey = true;
  bool _isLoadingJerseyTypes = true;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    final authState = ref.read(authProviderProvider);
    if (authState.isAuthenticated) {
      // Get token from SharedPreferences
      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString('auth_token');
      
      if (token != null) {
        // Load fan points
        final points = await _apiService.getFanPoints(token);
        if (mounted) {
          setState(() {
            _fanPoints = points;
            _isLoadingPoints = false;
          });
        }

        // Load fan jersey
        final jersey = await _apiService.getFanJersey(token);
        if (mounted) {
          setState(() {
            _fanJersey = jersey;
            _isLoadingJersey = false;
          });
        }

        // Load jersey types and available jerseys
        final jerseyTypes = await _apiService.getJerseyTypes();
        final availableJerseys = await _apiService.getAllJerseys();
        if (mounted) {
          setState(() {
            _jerseyTypes = jerseyTypes;
            _availableJerseys = availableJerseys;
            _isLoadingJerseyTypes = false;
          });
        }
      } else {
        setState(() {
          _isLoadingPoints = false;
          _isLoadingJersey = false;
          _isLoadingJerseyTypes = false;
        });
      }
    } else {
      setState(() {
        _isLoadingPoints = false;
        _isLoadingJersey = false;
        _isLoadingJerseyTypes = false;
      });
    }

    // Load admin notices
    final notices = await _apiService.getAdminNotices();
    if (mounted) {
      setState(() {
        _adminNotices = notices;
        _isLoadingNotices = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    final authState = ref.watch(authProviderProvider);
    
    // Show login prompt only if user is not authenticated
    if (!authState.isAuthenticated || authState.fan == null) {
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
                  context.go(AppRoutes.login);
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

    // Use actual authenticated fan data
    final fan = authState.fan!;
    
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
              
              // Jersey Section
              _buildJerseySection(context, fan, isEnglish),
              const SizedBox(height: 32),
              
              // Closest Shop Section
              _buildClosestShopSection(context, isEnglish),
              const SizedBox(height: 32),
              
              // Admin Notices Section
              _buildAdminNoticesSection(context, isEnglish),
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
      child: Column(
        children: [
          // Top Row with Profile Image and Info
          Row(
            children: [
              // Profile Image
              Container(
                width: 80,
                height: 80,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: AppColors.primaryBlue.withOpacity(0.1),
                ),
                child: fan.profileImage != null
                    ? ClipOval(
                        child: CachedNetworkImage(
                          imageUrl: fan.profileImage!,
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
                      fan.fullName,
                      style: Theme.of(context).textTheme.titleLarge?.copyWith(
                        color: AppColors.textPrimary,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      fan.email,
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
                        Expanded(
                          child: Text(
                            fan.location ?? 'No location',
                            style: Theme.of(context).textTheme.bodySmall?.copyWith(
                              color: AppColors.textSecondary,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          
          // Points Display (moved to separate row)
          _buildPointsCard(context, isEnglish),
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
            fan.phone ?? 'No phone number',
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
          
          // Admin Panel Access
          _buildSettingRow(
            context,
            Icons.admin_panel_settings,
            isEnglish ? 'Admin Panel' : 'Paneli ya Msimamizi',
            isEnglish ? 'Manage products and content' : 'Simamia bidhaa na maudhui',
            () {
              AppRoutes.goToAdmin(context);
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

  Widget _buildPointsCard(BuildContext context, bool isEnglish) {
    if (_isLoadingPoints) {
      return Container(
        padding: const EdgeInsets.all(16),
        height: 200,
        child: const Center(
          child: CircularProgressIndicator(),
        ),
      );
    }

    final totalPoints = _fanPoints?['total_points'] ?? 0;
    final pointsBreakdown = {
      'login': {'points': _fanPoints?['daily_login_points'] ?? 0, 'label': isEnglish ? 'Daily Login' : 'Kuingia Kila Siku'},
      'matches': {'points': _fanPoints?['match_points'] ?? 0, 'label': isEnglish ? 'Match Wins' : 'Ushindi wa Mechi'},
      'bonus': {'points': _fanPoints?['bonus_points'] ?? 0, 'label': isEnglish ? 'Special Bonus' : 'Bonus Maalum'},
    };

    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        gradient: LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            AppColors.primaryBlue,
            AppColors.primaryBlue.withOpacity(0.8),
          ],
        ),
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: AppColors.primaryBlue.withOpacity(0.3),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Header
          Row(
            children: [
              Icon(
                Icons.stars,
                color: Colors.white,
                size: 24,
              ),
              const SizedBox(width: 8),
              Text(
                isEnglish ? 'Your Points' : 'Pointi Zako',
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 18,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          
          // Total Points
          Row(
            children: [
              Text(
                totalPoints.toString(),
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 36,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(width: 8),
              Text(
                isEnglish ? 'Total Points' : 'Jumla ya Pointi',
                style: TextStyle(
                  color: Colors.white.withOpacity(0.9),
                  fontSize: 14,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          
          // Points Breakdown
          ...pointsBreakdown.entries.map((entry) => Padding(
            padding: const EdgeInsets.only(bottom: 8),
            child: Row(
              children: [
                Container(
                  width: 8,
                  height: 8,
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.8),
                    shape: BoxShape.circle,
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Text(
                    entry.value['label'] as String,
                    style: TextStyle(
                      color: Colors.white.withOpacity(0.9),
                      fontSize: 14,
                    ),
                  ),
                ),
                Text(
                  '+${entry.value['points']}',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 14,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          )).toList(),
          
          const SizedBox(height: 12),
          
          // View History Button
          GestureDetector(
            onTap: () {
              _showPointsHistoryModal(context, isEnglish);
            },
            child: Container(
              padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 12),
              decoration: BoxDecoration(
                color: Colors.white.withOpacity(0.2),
                borderRadius: BorderRadius.circular(8),
                border: Border.all(
                  color: Colors.white.withOpacity(0.3),
                  width: 1,
                ),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(
                    Icons.history,
                    color: Colors.white,
                    size: 16,
                  ),
                  const SizedBox(width: 6),
                  Text(
                    isEnglish ? 'View History' : 'Ona Historia',
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 12,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _showJerseyEditModal(BuildContext context, bool isEnglish) {
    final TextEditingController nameController = TextEditingController(
      text: _fanJersey?['jersey_name'] ?? 'AZAM FAN'
    );
    final TextEditingController numberController = TextEditingController(
      text: _fanJersey?['jersey_number']?.toString() ?? '1'
    );
    String selectedJerseyType = _fanJersey?['jersey_type'] ?? 'home';

    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        backgroundColor: AppColors.cardBackground,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
        ),
        title: Row(
          children: [
            Icon(
              Icons.edit,
              color: AppColors.primaryBlue,
              size: 24,
            ),
            const SizedBox(width: 8),
            Text(
              isEnglish ? 'Edit Jersey Details' : 'Hariri Maelezo ya Jezi',
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 18,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Jersey Name Field
            Text(
              isEnglish ? 'Jersey Name' : 'Jina la Jezi',
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
            const SizedBox(height: 8),
            TextField(
              controller: nameController,
              maxLength: 12,
              textCapitalization: TextCapitalization.characters,
              decoration: InputDecoration(
                hintText: isEnglish ? 'Enter your name' : 'Ingiza jina lako',
                hintStyle: TextStyle(color: AppColors.textSecondary),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide(color: AppColors.textSecondary.withOpacity(0.3)),
                ),
                focusedBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide(color: AppColors.primaryBlue, width: 2),
                ),
                contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                counterStyle: TextStyle(color: AppColors.textSecondary, fontSize: 12),
              ),
              style: TextStyle(color: AppColors.textPrimary),
            ),
            const SizedBox(height: 16),
            
            // Jersey Number Field
            Text(
              isEnglish ? 'Jersey Number' : 'Nambari ya Jezi',
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
            const SizedBox(height: 8),
            TextField(
              controller: numberController,
              keyboardType: TextInputType.number,
              maxLength: 2,
              decoration: InputDecoration(
                hintText: isEnglish ? 'Enter number (1-99)' : 'Ingiza nambari (1-99)',
                hintStyle: TextStyle(color: AppColors.textSecondary),
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide(color: AppColors.textSecondary.withOpacity(0.3)),
                ),
                focusedBorder: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8),
                  borderSide: BorderSide(color: AppColors.primaryBlue, width: 2),
                ),
                contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                counterStyle: TextStyle(color: AppColors.textSecondary, fontSize: 12),
              ),
              style: TextStyle(color: AppColors.textPrimary),
            ),
            const SizedBox(height: 16),
            
            // Jersey Type Field
            Text(
              isEnglish ? 'Jersey Type' : 'Aina ya Jezi',
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 14,
                fontWeight: FontWeight.w500,
              ),
            ),
            const SizedBox(height: 8),
            StatefulBuilder(
              builder: (context, setState) {
                return DropdownButtonFormField<String>(
                  value: selectedJerseyType,
                  decoration: InputDecoration(
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(8),
                      borderSide: BorderSide(color: AppColors.textSecondary.withOpacity(0.3)),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(8),
                      borderSide: BorderSide(color: AppColors.primaryBlue, width: 2),
                    ),
                    contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                  ),
                  dropdownColor: AppColors.cardBackground,
                  style: TextStyle(color: AppColors.textPrimary),
                  items: _isLoadingJerseyTypes || _jerseyTypes == null
                      ? [
                          DropdownMenuItem(
                            value: 'home',
                            child: Text(isEnglish ? 'Home Jersey' : 'Jezi ya Nyumbani'),
                          ),
                          DropdownMenuItem(
                            value: 'away',
                            child: Text(isEnglish ? 'Away Jersey' : 'Jezi ya Nje'),
                          ),
                          DropdownMenuItem(
                            value: 'third',
                            child: Text(isEnglish ? 'Third Jersey' : 'Jezi ya Tatu'),
                          ),
                        ]
                      : (_jerseyTypes!['data'] as List<dynamic>).map<DropdownMenuItem<String>>((jerseyType) {
                          final type = jerseyType['type'] as String;
                          final name = jerseyType['name'] as String;
                          final isAvailable = jerseyType['available'] as bool;
                          
                          return DropdownMenuItem(
                            value: type,
                            enabled: isAvailable,
                            child: Row(
                              children: [
                                Text(
                                  name,
                                  style: TextStyle(
                                    color: isAvailable ? AppColors.textPrimary : AppColors.textSecondary,
                                  ),
                                ),
                                if (!isAvailable) const SizedBox(width: 8),
                                if (!isAvailable) Text(
                                  isEnglish ? '(Not Available)' : '(Haipatikani)',
                                  style: TextStyle(
                                    color: AppColors.textSecondary,
                                    fontSize: 12,
                                  ),
                                ),
                              ],
                            ),
                          );
                        }).toList(),
                  onChanged: (String? newValue) {
                    if (newValue != null) {
                      setState(() {
                        selectedJerseyType = newValue;
                      });
                    }
                  },
                );
              },
            ),
            const SizedBox(height: 16),
            
            // Info text
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: Colors.blue.withOpacity(0.1),
                borderRadius: BorderRadius.circular(8),
                border: Border.all(
                  color: Colors.blue.withOpacity(0.3),
                  width: 1,
                ),
              ),
              child: Row(
                children: [
                  Icon(
                    Icons.info_outline,
                    color: Colors.blue,
                    size: 16,
                  ),
                  const SizedBox(width: 8),
                  Expanded(
                    child: Text(
                      isEnglish 
                          ? 'Changes will be reflected on your personalized jersey immediately.'
                          : 'Mabadiliko yataonekana kwenye jezi yako ya kibinafsi mara moja.',
                      style: TextStyle(
                        color: Colors.blue.shade700,
                        fontSize: 12,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: Text(
              isEnglish ? 'Cancel' : 'Ghairi',
              style: TextStyle(
                color: AppColors.textSecondary,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
          ElevatedButton(
            onPressed: () async {
              // Validate inputs
              final name = nameController.text.trim().toUpperCase();
              final numberText = numberController.text.trim();
              
              if (name.isEmpty) {
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text(
                      isEnglish ? 'Please enter a jersey name' : 'Tafadhali ingiza jina la jezi',
                    ),
                    backgroundColor: Colors.red,
                  ),
                );
                return;
              }
              
              final number = int.tryParse(numberText);
              if (number == null || number < 1 || number > 99) {
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text(
                      isEnglish ? 'Please enter a valid number (1-99)' : 'Tafadhali ingiza nambari sahihi (1-99)',
                    ),
                    backgroundColor: Colors.red,
                  ),
                );
                return;
              }
              
              try {
                // Get auth token
                final prefs = await SharedPreferences.getInstance();
                final token = prefs.getString('auth_token');
                
                if (token != null) {
                  // Update jersey via API
                  await _apiService.updateFanJersey(token, name, number, jerseyType: selectedJerseyType);
                  
                  // Update local state
                  setState(() {
                    _fanJersey = {
                      'jersey_name': name,
                      'jersey_number': number,
                      'jersey_type': selectedJerseyType,
                      'fan_name': _fanJersey?['fan_name'] ?? 'Fan',
                    };
                  });
                  
                  Navigator.pop(context);
                  
                  // Show success message
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(
                      content: Text(
                        isEnglish 
                            ? 'Jersey details updated successfully!'
                            : 'Maelezo ya jezi yamebadilishwa kikamilifu!',
                      ),
                      backgroundColor: Colors.green,
                    ),
                  );
                } else {
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(
                      content: Text(
                        isEnglish ? 'Authentication required' : 'Uthibitisho unahitajika',
                      ),
                      backgroundColor: Colors.red,
                    ),
                  );
                }
              } catch (e) {
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text(
                      isEnglish ? 'Failed to update jersey details' : 'Imeshindwa kubadilisha maelezo ya jezi',
                    ),
                    backgroundColor: Colors.red,
                  ),
                );
              }
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: AppColors.primaryBlue,
              foregroundColor: Colors.white,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
            ),
            child: Text(
              isEnglish ? 'Save Changes' : 'Hifadhi Mabadiliko',
              style: const TextStyle(
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _showPointsHistoryModal(BuildContext context, bool isEnglish) {
    // Demo transaction history
    final transactions = [
      {
        'type': 'earned',
        'points': 50,
        'reason': isEnglish ? 'Daily login bonus' : 'Bonus ya kuingia kila siku',
        'date': '2024-01-15',
        'time': '08:30',
      },
      {
        'type': 'earned',
        'points': 100,
        'reason': isEnglish ? 'Match victory vs Simba SC' : 'Ushindi dhidi ya Simba SC',
        'date': '2024-01-14',
        'time': '16:45',
      },
      {
        'type': 'earned',
        'points': 25,
        'reason': isEnglish ? 'Profile completion' : 'Kukamilisha wasifu',
        'date': '2024-01-13',
        'time': '12:15',
      },
      {
        'type': 'earned',
        'points': 75,
        'reason': isEnglish ? 'Weekly challenge completed' : 'Changamoto ya wiki imekamilika',
        'date': '2024-01-12',
        'time': '19:20',
      },
    ];

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (context) => Container(
        height: MediaQuery.of(context).size.height * 0.7,
        decoration: BoxDecoration(
          color: AppColors.cardBackground,
          borderRadius: const BorderRadius.only(
            topLeft: Radius.circular(20),
            topRight: Radius.circular(20),
          ),
        ),
        child: Column(
          children: [
            // Handle
            Container(
              margin: const EdgeInsets.only(top: 12),
              width: 40,
              height: 4,
              decoration: BoxDecoration(
                color: AppColors.textSecondary.withOpacity(0.3),
                borderRadius: BorderRadius.circular(2),
              ),
            ),
            
            // Header
            Padding(
              padding: const EdgeInsets.all(20),
              child: Row(
                children: [
                  Icon(
                    Icons.history,
                    color: AppColors.primaryBlue,
                    size: 24,
                  ),
                  const SizedBox(width: 8),
                  Text(
                    isEnglish ? 'Points History' : 'Historia ya Pointi',
                    style: Theme.of(context).textTheme.titleLarge?.copyWith(
                      color: AppColors.textPrimary,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  const Spacer(),
                  IconButton(
                    onPressed: () => Navigator.pop(context),
                    icon: Icon(
                      Icons.close,
                      color: AppColors.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
            
            // Transaction List
            Expanded(
              child: ListView.builder(
                padding: const EdgeInsets.symmetric(horizontal: 20),
                itemCount: transactions.length,
                itemBuilder: (context, index) {
                  final transaction = transactions[index];
                  return Container(
                    margin: const EdgeInsets.only(bottom: 12),
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: AppColors.cardBackground,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: AppColors.textSecondary.withOpacity(0.1),
                        width: 1,
                      ),
                    ),
                    child: Row(
                      children: [
                        // Points indicator
                        Container(
                          width: 40,
                          height: 40,
                          decoration: BoxDecoration(
                            color: Colors.green.withOpacity(0.1),
                            shape: BoxShape.circle,
                          ),
                          child: Icon(
                            Icons.add,
                            color: Colors.green,
                            size: 20,
                          ),
                        ),
                        const SizedBox(width: 12),
                        
                        // Transaction details
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                transaction['reason'] as String,
                                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                  color: AppColors.textPrimary,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                              const SizedBox(height: 4),
                              Text(
                                '${transaction['date']} • ${transaction['time']}',
                                style: Theme.of(context).textTheme.bodySmall?.copyWith(
                                  color: AppColors.textSecondary,
                                ),
                              ),
                            ],
                          ),
                        ),
                        
                        // Points amount
                        Text(
                          '+${transaction['points']}',
                          style: Theme.of(context).textTheme.titleMedium?.copyWith(
                            color: Colors.green,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ],
                    ),
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildJerseySection(BuildContext context, fan, bool isEnglish) {
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
          Row(
            children: [
              Icon(
                Icons.sports_soccer,
                color: AppColors.primaryBlue,
                size: 24,
              ),
              const SizedBox(width: 8),
              Text(
                isEnglish ? 'Your Personalized Jersey' : 'Jezi Yako ya Kibinafsi',
                style: Theme.of(context).textTheme.titleMedium?.copyWith(
                  color: AppColors.textPrimary,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
          const SizedBox(height: 20),
          
          // Jersey Display
          Center(
            child: Container(
              width: 200,
              height: 240,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: AppColors.primaryBlue.withOpacity(0.3),
                    blurRadius: 15,
                    offset: const Offset(0, 5),
                  ),
                ],
              ),
              child: Stack(
                children: [
                  // Jersey background image
                  Positioned.fill(
                    child: ClipRRect(
                      borderRadius: BorderRadius.circular(12),
                      child: _isLoadingJersey
                          ? Container(
                              color: AppColors.primaryBlue.withOpacity(0.3),
                              child: const Center(
                                child: CircularProgressIndicator(
                                  color: Colors.white,
                                ),
                              ),
                            )
                          : _fanJersey?['jersey_image_url'] != null
                              ? CachedNetworkImage(
                                  imageUrl: _fanJersey!['jersey_image_url'],
                                  fit: BoxFit.cover,
                                  placeholder: (context, url) => Container(
                                    color: AppColors.primaryBlue.withOpacity(0.3),
                                    child: const Center(
                                      child: CircularProgressIndicator(
                                        color: Colors.white,
                                      ),
                                    ),
                                  ),
                                  errorWidget: (context, url, error) {
                                    return Container(
                                      decoration: BoxDecoration(
                                        gradient: LinearGradient(
                                          begin: Alignment.topCenter,
                                          end: Alignment.bottomCenter,
                                          colors: [
                                            AppColors.primaryBlue,
                                            AppColors.primaryBlue.withOpacity(0.8),
                                          ],
                                        ),
                                      ),
                                    );
                                  },
                                )
                              : Container(
                                  decoration: BoxDecoration(
                                    gradient: LinearGradient(
                                      begin: Alignment.topCenter,
                                      end: Alignment.bottomCenter,
                                      colors: [
                                        AppColors.primaryBlue,
                                        AppColors.primaryBlue.withOpacity(0.8),
                                      ],
                                    ),
                                  ),
                                ),
                    ),
                  ),
                  
                  // Jersey name (curved at top)
                  Positioned(
                    top: 30,
                    left: 0,
                    right: 0,
                    child: Text(
                      _isLoadingJersey 
                          ? 'LOADING...' 
                          : (_fanJersey?['jersey_name'] ?? 'AZAM FAN'),
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 14,
                        fontWeight: FontWeight.bold,
                        letterSpacing: 2,
                      ),
                    ),
                  ),
                  
                  // Jersey number (large in center)
                  Positioned(
                    top: 80,
                    left: 0,
                    right: 0,
                    child: Text(
                      _isLoadingJersey 
                          ? '...' 
                          : (_fanJersey?['jersey_number']?.toString() ?? '1'),
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 72,
                        fontWeight: FontWeight.bold,
                        height: 1,
                      ),
                    ),
                  ),
                  
                  // AZAM FC logo/text at bottom
                  Positioned(
                    bottom: 20,
                    left: 0,
                    right: 0,
                    child: Text(
                      'AZAM FC',
                      textAlign: TextAlign.center,
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        letterSpacing: 1,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
          
          const SizedBox(height: 20),
          
          // Edit button
          Center(
            child: ElevatedButton.icon(
              onPressed: () {
                _showJerseyEditModal(context, isEnglish);
              },
              icon: const Icon(Icons.edit, size: 18),
              label: Text(
                isEnglish ? 'Edit Jersey Details' : 'Hariri Maelezo ya Jezi',
                style: const TextStyle(fontSize: 14),
              ),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.primaryBlue,
                foregroundColor: Colors.white,
                padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildClosestShopSection(BuildContext context, bool isEnglish) {
    // Demo shop data
    final closestShops = [
      {
        'name': 'Azam FC Store - Kariakoo',
        'address': 'Kariakoo Market, Dar es Salaam',
        'distance': '2.5 km',
        'phone': '+255 22 218 0000',
        'hours': '8:00 AM - 8:00 PM',
        'isOpen': true,
      },
      {
        'name': 'Azam FC Store - Mlimani City',
        'address': 'Mlimani City Mall, Dar es Salaam',
        'distance': '5.2 km',
        'phone': '+255 22 270 0000',
        'hours': '10:00 AM - 10:00 PM',
        'isOpen': true,
      },
      {
        'name': 'Azam FC Store - Mwenge',
        'address': 'Mwenge, Kinondoni, Dar es Salaam',
        'distance': '8.1 km',
        'phone': '+255 22 260 0000',
        'hours': '9:00 AM - 7:00 PM',
        'isOpen': false,
      },
    ];

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
          Row(
            children: [
              Icon(
                Icons.store,
                color: AppColors.primaryBlue,
                size: 24,
              ),
              const SizedBox(width: 8),
              Text(
                isEnglish ? 'Nearest Azam FC Stores' : 'Maduka ya Azam FC Karibu',
                style: Theme.of(context).textTheme.titleMedium?.copyWith(
                  color: AppColors.textPrimary,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          
          ...closestShops.take(2).map((shop) => Container(
            margin: const EdgeInsets.only(bottom: 16),
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              border: Border.all(
                color: AppColors.primaryBlue.withOpacity(0.1),
                width: 1,
              ),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.03),
                  blurRadius: 8,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Expanded(
                      child: Text(
                        shop['name'] as String,
                        style: Theme.of(context).textTheme.titleSmall?.copyWith(
                          color: AppColors.textPrimary,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                      decoration: BoxDecoration(
                        color: (shop['isOpen'] as bool? ?? false) 
                            ? Colors.green.withOpacity(0.1)
                            : Colors.red.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: Text(
                        (shop['isOpen'] as bool? ?? false) 
                            ? (isEnglish ? 'Open' : 'Imefunguka')
                            : (isEnglish ? 'Closed' : 'Imefungwa'),
                        style: TextStyle(
                          color: (shop['isOpen'] as bool? ?? false) ? Colors.green : Colors.red,
                          fontSize: 12,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                
                Row(
                  children: [
                    Icon(
                      Icons.location_on,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 4),
                    Expanded(
                      child: Text(
                        shop['address'] as String,
                        style: Theme.of(context).textTheme.bodySmall?.copyWith(
                          color: AppColors.textSecondary,
                        ),
                      ),
                    ),
                    Text(
                      shop['distance'] as String,
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.primaryBlue,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                
                Row(
                  children: [
                    Icon(
                      Icons.access_time,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      shop['hours'] as String,
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),
                
                Row(
                  children: [
                    Expanded(
                      child: OutlinedButton.icon(
                        onPressed: () {
                          // TODO: Implement call functionality
                        },
                        icon: const Icon(Icons.phone, size: 16),
                        label: Text(
                          isEnglish ? 'Call' : 'Piga Simu',
                          style: const TextStyle(fontSize: 12),
                        ),
                        style: OutlinedButton.styleFrom(
                          foregroundColor: AppColors.primaryBlue,
                          side: BorderSide(color: AppColors.primaryBlue),
                          padding: const EdgeInsets.symmetric(vertical: 8),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          )).toList(),
          
          // View All Stores Button
          Center(
            child: TextButton.icon(
              onPressed: () {
                _showAllStoresModal(context, closestShops, isEnglish);
              },
              icon: Icon(
                Icons.store,
                size: 16,
                color: AppColors.primaryBlue,
              ),
              label: Text(
                isEnglish ? 'View All Stores' : 'Ona Maduka Yote',
                style: TextStyle(
                  color: AppColors.primaryBlue,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _showAllStoresModal(BuildContext context, List<Map<String, dynamic>> shops, bool isEnglish) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        backgroundColor: AppColors.cardBackground,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(16),
        ),
        title: Row(
          children: [
            Icon(
              Icons.store,
              color: AppColors.primaryBlue,
              size: 24,
            ),
            const SizedBox(width: 8),
            Text(
              isEnglish ? 'All Azam FC Stores' : 'Maduka Yote ya Azam FC',
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 18,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
        content: SizedBox(
          width: double.maxFinite,
          child: ListView.builder(
            shrinkWrap: true,
            itemCount: shops.length,
            itemBuilder: (context, index) {
              final shop = shops[index];
              return Container(
                margin: const EdgeInsets.only(bottom: 12),
                padding: const EdgeInsets.all(12),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(8),
                  border: Border.all(
                    color: AppColors.primaryBlue.withOpacity(0.1),
                    width: 1,
                  ),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      children: [
                        Expanded(
                          child: Text(
                            shop['name'] as String,
                            style: TextStyle(
                              color: AppColors.textPrimary,
                              fontWeight: FontWeight.w600,
                              fontSize: 14,
                            ),
                          ),
                        ),
                        Text(
                          shop['distance'] as String,
                          style: TextStyle(
                            color: AppColors.primaryBlue,
                            fontWeight: FontWeight.w600,
                            fontSize: 12,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 4),
                    Text(
                      shop['address'] as String,
                      style: TextStyle(
                        color: AppColors.textSecondary,
                        fontSize: 12,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      shop['hours'] as String,
                      style: TextStyle(
                        color: AppColors.textSecondary,
                        fontSize: 12,
                      ),
                    ),
                  ],
                ),
              );
            },
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(),
            child: Text(
              isEnglish ? 'Close' : 'Funga',
              style: TextStyle(color: AppColors.primaryBlue),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildAdminNoticesSection(BuildContext context, bool isEnglish) {
    if (_isLoadingNotices) {
      return Container(
        padding: const EdgeInsets.all(20),
        height: 100,
        child: const Center(
          child: CircularProgressIndicator(),
        ),
      );
    }

    if (_adminNotices.isEmpty) {
      return const SizedBox.shrink();
    }

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
          Row(
            children: [
              Icon(
                Icons.notifications_active,
                color: AppColors.primaryBlue,
                size: 24,
              ),
              const SizedBox(width: 8),
              Text(
                isEnglish ? 'Notices & Alerts' : 'Arifa na Tahadhari',
                style: Theme.of(context).textTheme.titleMedium?.copyWith(
                  color: AppColors.textPrimary,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          
          ..._adminNotices.map((notice) => Container(
            margin: const EdgeInsets.only(bottom: 12),
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: _getNoticeColor(notice['type'] as String? ?? 'info').withOpacity(0.1),
              borderRadius: BorderRadius.circular(8),
              border: Border.all(
                color: _getNoticeColor(notice['type'] as String? ?? 'info').withOpacity(0.3),
                width: 1,
              ),
            ),
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Icon(
                  _getNoticeIcon(notice['type'] as String? ?? 'info'),
                  color: _getNoticeColor(notice['type'] as String? ?? 'info'),
                  size: 20,
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        notice['title'] as String? ?? '',
                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                          color: AppColors.textPrimary,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        notice['content'] as String? ?? '',
                        style: Theme.of(context).textTheme.bodySmall?.copyWith(
                          color: AppColors.textSecondary,
                        ),
                      ),
                    ],
                  ),
                ),
                if (notice['is_dismissible'] as bool? ?? false)
                  IconButton(
                    onPressed: () {
                      // TODO: Implement dismiss functionality
                    },
                    icon: Icon(
                      Icons.close,
                      size: 18,
                      color: AppColors.textSecondary,
                    ),
                    padding: EdgeInsets.zero,
                    constraints: const BoxConstraints(),
                  ),
              ],
            ),
          )).toList(),
        ],
      ),
    );
  }

  Color _getNoticeColor(String type) {
    switch (type) {
      case 'info':
        return Colors.blue;
      case 'warning':
        return Colors.orange;
      case 'success':
        return Colors.green;
      case 'error':
        return Colors.red;
      default:
        return AppColors.primaryBlue;
    }
  }

  IconData _getNoticeIcon(String type) {
    switch (type) {
      case 'info':
        return Icons.info_outline;
      case 'warning':
        return Icons.warning_amber_outlined;
      case 'success':
        return Icons.check_circle_outline;
      case 'error':
        return Icons.error_outline;
      default:
        return Icons.notifications_outlined;
    }
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
