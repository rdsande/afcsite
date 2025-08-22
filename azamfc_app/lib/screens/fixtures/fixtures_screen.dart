import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:intl/intl.dart';

import '../../constants/app_colors.dart';
import '../../constants/app_routes.dart';
import '../../providers/language_provider.dart';
import '../../providers/fixtures_provider.dart';
import '../../widgets/fixture_card.dart';
import '../../models/fixture.dart';

class FixturesScreen extends ConsumerStatefulWidget {
  const FixturesScreen({super.key});

  @override
  ConsumerState<FixturesScreen> createState() => _FixturesScreenState();
}

class _FixturesScreenState extends ConsumerState<FixturesScreen>
    with SingleTickerProviderStateMixin {
  late TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 2, vsync: this);
    
    // Load fixtures data
    WidgetsBinding.instance.addPostFrameCallback((_) {
      ref.read(fixturesProvider.notifier).fetchUpcomingFixtures();
      ref.read(fixturesProvider.notifier).fetchRecentResults();
    });
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: Column(
        children: [
          // Tab Bar
          Container(
            margin: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
            decoration: BoxDecoration(
              color: AppColors.white,
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: AppColors.shadowColorLight,
                  blurRadius: 10,
                  offset: const Offset(0, 4),
                ),
              ],
            ),
            child: TabBar(
              controller: _tabController,
              indicator: BoxDecoration(
                color: AppColors.primaryBlue,
                borderRadius: BorderRadius.circular(12),
              ),
              labelColor: AppColors.white,
              unselectedLabelColor: AppColors.textSecondary,
              labelStyle: const TextStyle(
                fontWeight: FontWeight.w600,
                fontSize: 16,
              ),
              unselectedLabelStyle: const TextStyle(
                fontWeight: FontWeight.w500,
                fontSize: 16,
              ),
              tabs: [
                Tab(
                  text: isEnglish ? 'Fixtures' : 'Michuano',
                ),
                Tab(
                  text: isEnglish ? 'Results' : 'Matokeo',
                ),
              ],
            ),
          ),
          
          // Tab Views
          Expanded(
            child: TabBarView(
              controller: _tabController,
              children: [
                _buildFixturesTab(isEnglish),
                _buildResultsTab(isEnglish),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFixturesTab(bool isEnglish) {
    return Consumer(
      builder: (context, ref, child) {
        final upcomingFixtures = ref.watch(upcomingFixturesProvider);
        final isLoading = ref.watch(fixturesLoadingProvider);
        final error = ref.watch(fixturesErrorProvider);

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
                  isEnglish ? 'Failed to load fixtures' : 'Imeshindwa kupakia michuano',
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    color: AppColors.error,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  error,
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.textSecondary,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 16),
                ElevatedButton(
                  onPressed: () {
                    ref.read(fixturesProvider.notifier).fetchUpcomingFixtures();
                  },
                  child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
                ),
              ],
            ),
          );
        }

        if (upcomingFixtures.isEmpty) {
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
                  isEnglish ? 'No upcoming fixtures' : 'Hakuna michuano ijayo',
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    color: AppColors.textSecondary,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          );
        }

        return ListView.builder(
          padding: const EdgeInsets.symmetric(horizontal: 24),
          itemCount: upcomingFixtures.length,
          itemBuilder: (context, index) {
            final fixture = upcomingFixtures[index];
            return Padding(
              padding: const EdgeInsets.only(bottom: 16),
              child: GestureDetector(
                onTap: () {
                  AppRoutes.goToFixtureDetail(context, fixture.id.toString());
                },
                child: FixtureCard(
                  fixture: _convertFixtureToFixtureData(fixture),
                  isEnglish: isEnglish,
                ),
              ),
            );
          },
        );
      },
    );
  }

  Widget _buildResultsTab(bool isEnglish) {
    return Consumer(
      builder: (context, ref, child) {
        final recentResults = ref.watch(recentResultsProvider);
        final isLoading = ref.watch(fixturesLoadingProvider);
        final error = ref.watch(fixturesErrorProvider);

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
                  isEnglish ? 'Failed to load results' : 'Imeshindwa kupakia matokeo',
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    color: AppColors.error,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  error,
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.textSecondary,
                  ),
                  textAlign: TextAlign.center,
                ),
                const SizedBox(height: 16),
                ElevatedButton(
                  onPressed: () {
                    ref.read(fixturesProvider.notifier).fetchRecentResults();
                  },
                  child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
                ),
              ],
            ),
          );
        }

        if (recentResults.isEmpty) {
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
                  isEnglish ? 'No recent results' : 'Hakuna matokeo ya hivi karibuni',
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                    color: AppColors.textSecondary,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
          );
        }

        return ListView.builder(
          padding: const EdgeInsets.symmetric(horizontal: 24),
          itemCount: recentResults.length,
          itemBuilder: (context, index) {
            final fixture = recentResults[index];
            return Padding(
              padding: const EdgeInsets.only(bottom: 16),
              child: GestureDetector(
                onTap: () {
                  AppRoutes.goToFixtureDetail(context, fixture.id.toString());
                },
                child: FixtureCard(
                  fixture: _convertFixtureToFixtureData(fixture),
                  isEnglish: isEnglish,
                ),
              ),
            );
          },
        );
      },
    );
  }

  // Helper method to convert Fixture model to FixtureData
  FixtureData _convertFixtureToFixtureData(Fixture fixture) {
    final dateFormat = DateFormat('EEE dd MMM');
    final timeFormat = DateFormat('HH:mm');
    
    return FixtureData(
      homeTeam: fixture.homeTeam,
      awayTeam: fixture.awayTeam,
      competition: fixture.tournament,
      date: dateFormat.format(fixture.matchDate),
      time: timeFormat.format(fixture.matchDate),
      venue: fixture.venue,
      homeTeamLogo: fixture.homeTeamLogo ?? '',
      awayTeamLogo: fixture.awayTeamLogo ?? '',
      homeScore: fixture.homeScore,
      awayScore: fixture.awayScore,
    );
  }
}
