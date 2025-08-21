import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';

import '../../constants/app_colors.dart';
import '../../providers/language_provider.dart';
import '../../providers/fixtures_provider.dart';
import '../../models/fixture.dart';

class FixtureDetailScreen extends ConsumerStatefulWidget {
  final String? fixtureId;

  const FixtureDetailScreen({super.key, this.fixtureId});

  @override
  ConsumerState<FixtureDetailScreen> createState() => _FixtureDetailScreenState();
}

class _FixtureDetailScreenState extends ConsumerState<FixtureDetailScreen> {
  Fixture? fixture;
  bool isLoading = true;
  String? error;

  @override
  void initState() {
    super.initState();
    _loadFixtureDetail();
  }

  Future<void> _loadFixtureDetail() async {
    if (widget.fixtureId == null) {
      setState(() {
        error = 'Invalid fixture ID';
        isLoading = false;
      });
      return;
    }

    try {
      final fixtureId = int.parse(widget.fixtureId!);
      final fixtureDetail = await ref.read(fixturesProvider.notifier).getFixtureDetail(fixtureId);
      
      setState(() {
        fixture = fixtureDetail;
        isLoading = false;
        error = fixtureDetail == null ? 'Fixture not found' : null;
      });
    } catch (e) {
      setState(() {
        error = 'Failed to load fixture: $e';
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      appBar: AppBar(
        title: Text(
          isEnglish ? 'Fixture Detail' : 'Maelezo ya Mchuano',
          style: const TextStyle(
            fontWeight: FontWeight.w700,
          ),
        ),
        backgroundColor: AppColors.backgroundColor,
        elevation: 0,
      ),
      body: _buildBody(context, isEnglish),
    );
  }

  Widget _buildBody(BuildContext context, bool isEnglish) {
    if (isLoading) {
      return const Center(
        child: CircularProgressIndicator(),
      );
    }

    if (error != null) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.error_outline,
              size: 64,
              color: AppColors.error,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish ? 'Failed to load fixture' : 'Imeshindwa kupakia mchuano',
              style: Theme.of(context).textTheme.titleLarge?.copyWith(
                color: AppColors.error,
                fontWeight: FontWeight.w600,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              error!,
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                color: AppColors.textSecondary,
              ),
              textAlign: TextAlign.center,
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: _loadFixtureDetail,
              child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
            ),
          ],
        ),
      );
    }

    if (fixture == null) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.sports_soccer,
              size: 64,
              color: AppColors.textSecondary,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish ? 'Fixture not found' : 'Mchuano haujapatikana',
              style: Theme.of(context).textTheme.titleLarge?.copyWith(
                color: AppColors.textSecondary,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      );
    }

    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Match Header
          Container(
            width: double.infinity,
            padding: const EdgeInsets.all(24),
            decoration: BoxDecoration(
              color: AppColors.white,
              boxShadow: [
                BoxShadow(
                  color: AppColors.shadowColorLight,
                  blurRadius: 10,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: Column(
              children: [
                // Competition
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                  decoration: BoxDecoration(
                    color: AppColors.primaryBlue.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: Text(
                    fixture!.tournament.toUpperCase(),
                    style: Theme.of(context).textTheme.labelLarge?.copyWith(
                      color: AppColors.primaryBlue,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),
                
                const SizedBox(height: 24),
                
                // Teams
                Row(
                  children: [
                    // Home Team
                    Expanded(
                      child: Column(
                        children: [
                          _buildTeamLogo(fixture!.homeTeamLogo),
                          const SizedBox(height: 12),
                          Text(
                            fixture!.homeTeam,
                            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                              fontWeight: FontWeight.w700,
                              color: AppColors.textPrimary,
                            ),
                            textAlign: TextAlign.center,
                          ),
                        ],
                      ),
                    ),
                    
                    // Score or VS
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
                      child: fixture!.homeScore != null && fixture!.awayScore != null
                          ? Column(
                              children: [
                                Text(
                                  '${fixture!.homeScore} - ${fixture!.awayScore}',
                                  style: Theme.of(context).textTheme.headlineLarge?.copyWith(
                                    color: AppColors.primaryBlue,
                                    fontWeight: FontWeight.w700,
                                  ),
                                ),
                                const SizedBox(height: 4),
                                Text(
                                  isEnglish ? 'FULL TIME' : 'MUDA KAMILI',
                                  style: Theme.of(context).textTheme.labelSmall?.copyWith(
                                    color: AppColors.textSecondary,
                                    fontWeight: FontWeight.w600,
                                  ),
                                ),
                              ],
                            )
                          : Text(
                              'VS',
                              style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                                color: AppColors.textSecondary,
                                fontWeight: FontWeight.w700,
                              ),
                            ),
                    ),
                    
                    // Away Team
                    Expanded(
                      child: Column(
                        children: [
                          _buildTeamLogo(fixture!.awayTeamLogo),
                          const SizedBox(height: 12),
                          Text(
                            fixture!.awayTeam,
                            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                              fontWeight: FontWeight.w700,
                              color: AppColors.textPrimary,
                            ),
                            textAlign: TextAlign.center,
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
                
                const SizedBox(height: 24),
                
                // Match Info
                Column(
                  children: [
                    // Date & Time
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(
                          Icons.access_time,
                          size: 18,
                          color: AppColors.textSecondary,
                        ),
                        const SizedBox(width: 8),
                        Text(
                          DateFormat('EEEE, MMMM dd, yyyy • HH:mm').format(fixture!.matchDate),
                          style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                            color: AppColors.textSecondary,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                      ],
                    ),
                    
                    const SizedBox(height: 12),
                    
                    // Venue
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(
                          Icons.location_on,
                          size: 18,
                          color: AppColors.textSecondary,
                        ),
                        const SizedBox(width: 8),
                        Expanded(
                          child: Text(
                            fixture!.venue,
                            style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                              color: AppColors.textSecondary,
                              fontWeight: FontWeight.w600,
                            ),
                            textAlign: TextAlign.center,
                          ),
                        ),
                      ],
                    ),
                    
                    const SizedBox(height: 12),
                    
                    // Status
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                      decoration: BoxDecoration(
                        color: _getStatusColor(fixture!.status).withOpacity(0.1),
                        borderRadius: BorderRadius.circular(16),
                      ),
                      child: Text(
                        _getStatusText(fixture!.status, isEnglish),
                        style: Theme.of(context).textTheme.labelMedium?.copyWith(
                          color: _getStatusColor(fixture!.status),
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
          
          const SizedBox(height: 24),
        ],
      ),
    );
  }

  Widget _buildTeamLogo(String? logoPath) {
    if (logoPath == null || logoPath.isEmpty) {
      return Container(
        width: 80,
        height: 80,
        decoration: BoxDecoration(
          color: AppColors.lightGrey,
          shape: BoxShape.circle,
        ),
        child: const Icon(
          Icons.sports_soccer,
          size: 40,
          color: AppColors.grey,
        ),
      );
    }

    if (logoPath.startsWith('http')) {
      return CachedNetworkImage(
        imageUrl: logoPath,
        width: 80,
        height: 80,
        fit: BoxFit.contain,
        placeholder: (context, url) => Container(
          width: 80,
          height: 80,
          decoration: BoxDecoration(
            color: AppColors.lightGrey,
            shape: BoxShape.circle,
          ),
          child: const CircularProgressIndicator(),
        ),
        errorWidget: (context, url, error) => Container(
          width: 80,
          height: 80,
          decoration: BoxDecoration(
            color: AppColors.lightGrey,
            shape: BoxShape.circle,
          ),
          child: const Icon(
            Icons.sports_soccer,
            size: 40,
            color: AppColors.grey,
          ),
        ),
      );
    }

    return Container(
      width: 80,
      height: 80,
      decoration: BoxDecoration(
        color: AppColors.lightGrey,
        shape: BoxShape.circle,
      ),
      child: const Icon(
        Icons.sports_soccer,
        size: 40,
        color: AppColors.grey,
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status.toLowerCase()) {
      case 'completed':
        return AppColors.success;
      case 'live':
        return AppColors.error;
      case 'scheduled':
        return AppColors.primaryBlue;
      case 'postponed':
      case 'cancelled':
        return AppColors.warning;
      default:
        return AppColors.textSecondary;
    }
  }

  String _getStatusText(String status, bool isEnglish) {
    switch (status.toLowerCase()) {
      case 'completed':
        return isEnglish ? 'COMPLETED' : 'IMEKAMILIKA';
      case 'live':
        return isEnglish ? 'LIVE' : 'MOJA KWA MOJA';
      case 'scheduled':
        return isEnglish ? 'SCHEDULED' : 'IMEPANGWA';
      case 'postponed':
        return isEnglish ? 'POSTPONED' : 'IMEAHIRISHWA';
      case 'cancelled':
        return isEnglish ? 'CANCELLED' : 'IMEGHAIRIWA';
      default:
        return status.toUpperCase();
    }
  }
}
