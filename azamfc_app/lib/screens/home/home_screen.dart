import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:intl/intl.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../../constants/app_colors.dart';
import '../../constants/app_routes.dart';
import '../../providers/language_provider.dart';
import '../../providers/news_provider.dart';
import '../../providers/fixtures_provider.dart';
import '../../providers/theme_provider.dart';
import '../../providers/auth_provider.dart';
import '../../widgets/azam_logo.dart';
import '../../widgets/match_card.dart';
import '../../widgets/fixture_card.dart';
import '../../models/news.dart';
import '../../models/fixture.dart';
import '../../utils/text_utils.dart';

class HomeScreen extends ConsumerStatefulWidget {
  const HomeScreen({super.key});

  @override
  ConsumerState<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends ConsumerState<HomeScreen> {
  int _selectedTabIndex = 0;

  @override
  void initState() {
    super.initState();
    // Fetch data when screen loads
    WidgetsBinding.instance.addPostFrameCallback((_) {
      ref.read(newsProvider.notifier).fetchAllNews();
      ref.read(fixturesProvider.notifier).fetchHomeFixtures();
    });
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';

    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: SafeArea(
        child: SingleChildScrollView(
          child: Column(
            children: [
              // Greeting Header
              _buildGreetingHeader(context, isEnglish),

              // Match Cards Section
              _buildMatchCardsSection(context, isEnglish),

              // Latest News Section
              _buildLatestNewsSection(context, isEnglish),

              // Tabs
              _buildTabs(context, isEnglish),

              // Content based on selected tab
              _selectedTabIndex == 0
                  ? _buildUpcomingMatchesTab(context, isEnglish)
                  : _buildMatchResultsTab(context, isEnglish),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildGreetingHeader(BuildContext context, bool isEnglish) {
    final now = DateTime.now();
    final hour = now.hour;
    final authState = ref.watch(authProviderProvider);

    String greeting;
    if (hour < 12) {
      greeting = isEnglish ? 'GOOD MORNING' : 'ASUBUHI NJEMA';
    } else if (hour < 17) {
      greeting = isEnglish ? 'GOOD AFTERNOON' : 'MCHANA MWEMA';
    } else {
      greeting = isEnglish ? 'GOOD EVENING' : 'JIONI NJEMA';
    }

    // Get user's first name or default to 'FAN'
    String userName = 'FAN';
    if (authState.isAuthenticated && authState.fan != null) {
      userName = authState.fan!.firstName.toUpperCase();
    }

    return Container(
      padding: const EdgeInsets.all(24),
      child: Column(
        children: [
          // Greeting Text
          Center(
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Text(
                  greeting,
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                        color: AppColors.textPrimary,
                        fontWeight: FontWeight.w900,
                        fontSize: 28,
                      ),
                ),
                const SizedBox(width: 8),
                Text(
                  userName,
                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                        color: AppColors.primaryBlue,
                        fontSize: 28,
                        fontWeight: FontWeight.w900,
                      ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLatestNewsSection(BuildContext context, bool isEnglish) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                isEnglish ? 'Latest News' : 'Habari za Hivi Karibuni',
                style: Theme.of(context).textTheme.titleMedium?.copyWith(
                      color: AppColors.textPrimary,
                      fontWeight: FontWeight.w700,
                      fontSize: 18,
                    ),
              ),
              Consumer(
                builder: (context, ref, child) {
                  final blueTheme = ref.watch(blueThemeProvider);
                  return TextButton(
                    onPressed: () {
                      AppRoutes.goToNews(context);
                    },
                    child: Text(
                      isEnglish ? 'View More' : 'Ona Zaidi',
                      style: TextStyle(
                        color: BlueThemeColors.getPrimaryColor(blueTheme),
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  );
                },
              ),
            ],
          ),
          const SizedBox(height: 16),
          // Show 3 latest news items
          Consumer(
            builder: (context, ref, child) {
              final newsState = ref.watch(newsProvider);
              final news = newsState.latestNews.take(5).toList();

              if (news.isEmpty) {
                return Container(
                  height: 120,
                  decoration: BoxDecoration(
                    color: AppColors.surfaceBackground,
                    borderRadius: BorderRadius.circular(12),
                  ),
                  child: Center(
                    child: Text(
                      isEnglish ? 'No news available' : 'Hakuna habari',
                      style: TextStyle(color: AppColors.textSecondary),
                    ),
                  ),
                );
              }

              return Column(
                children: news
                    .map((newsItem) => GestureDetector(
                          onTap: () {
                            AppRoutes.goToNewsDetail(
                                context, newsItem.id.toString());
                          },
                          child: Container(
                            margin: const EdgeInsets.only(bottom: 12),
                            padding: const EdgeInsets.all(16),
                            decoration: BoxDecoration(
                              color: AppColors.surfaceBackground,
                              borderRadius: BorderRadius.circular(12),
                            ),
                            child: Row(
                              children: [
                                Container(
                                  width: 60,
                                  height: 60,
                                  decoration: BoxDecoration(
                                    borderRadius: BorderRadius.circular(8),
                                  ),
                                  child: ClipRRect(
                                    borderRadius: BorderRadius.circular(8),
                                    child: newsItem.image != null &&
                                            newsItem.image!.isNotEmpty
                                        ? CachedNetworkImage(
                                            imageUrl: newsItem.image!,
                                            width: 60,
                                            height: 60,
                                            fit: BoxFit.cover,
                                            placeholder: (context, url) =>
                                                Container(
                                              color: BlueThemeColors
                                                      .getPrimaryColor(ref.watch(
                                                          blueThemeProvider))
                                                  .withOpacity(0.1),
                                              child: Icon(
                                                Icons.article,
                                                color: BlueThemeColors
                                                    .getPrimaryColor(ref.watch(
                                                        blueThemeProvider)),
                                              ),
                                            ),
                                            errorWidget:
                                                (context, url, error) =>
                                                    Container(
                                              color: BlueThemeColors
                                                      .getPrimaryColor(ref.watch(
                                                          blueThemeProvider))
                                                  .withOpacity(0.1),
                                              child: Icon(
                                                Icons.article,
                                                color: BlueThemeColors
                                                    .getPrimaryColor(ref.watch(
                                                        blueThemeProvider)),
                                              ),
                                            ),
                                          )
                                        : Container(
                                            color:
                                                BlueThemeColors.getPrimaryColor(
                                                        ref.watch(
                                                            blueThemeProvider))
                                                    .withOpacity(0.1),
                                            child: Icon(
                                              Icons.article,
                                              color: BlueThemeColors
                                                  .getPrimaryColor(ref.watch(
                                                      blueThemeProvider)),
                                            ),
                                          ),
                                  ),
                                ),
                                const SizedBox(width: 12),
                                Expanded(
                                  child: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Text(
                                        newsItem.title,
                                        style: Theme.of(context)
                                            .textTheme
                                            .titleSmall
                                            ?.copyWith(
                                              fontWeight: FontWeight.normal,
                                              color: AppColors.textPrimary,
                                            ),
                                        maxLines: 2,
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                      const SizedBox(height: 4),
                                      Text(
                                        DateFormat('MMM dd, yyyy')
                                            .format(newsItem.publishedAt),
                                        style: Theme.of(context)
                                            .textTheme
                                            .bodySmall
                                            ?.copyWith(
                                              color: AppColors.textSecondary,
                                            ),
                                      ),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ))
                    .toList(),
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildMatchCardsSection(BuildContext context, bool isEnglish) {
    return Container(
      height: 200,
      padding: const EdgeInsets.symmetric(horizontal: 24),
      child: Consumer(
        builder: (context, ref, child) {
          final upcomingFixtures = ref.watch(upcomingFixturesProvider);
          final recentResults = ref.watch(recentResultsProvider);
          final isLoading = ref.watch(fixturesLoadingProvider);

          if (isLoading) {
            return Row(
              children: [
                Expanded(
                  child: Container(
                    height: 180,
                    decoration: BoxDecoration(
                      color: AppColors.surfaceBackground,
                      borderRadius: BorderRadius.circular(16),
                    ),
                    child: const Center(
                      child: CircularProgressIndicator(),
                    ),
                  ),
                ),
                const SizedBox(width: 16),
                Expanded(
                  child: Container(
                    height: 180,
                    decoration: BoxDecoration(
                      color: AppColors.surfaceBackground,
                      borderRadius: BorderRadius.circular(16),
                    ),
                    child: const Center(
                      child: CircularProgressIndicator(),
                    ),
                  ),
                ),
              ],
            );
          }

          return Row(
            children: [
              // Previous Results Card
              Expanded(
                child: recentResults.isNotEmpty
                    ? _buildMatchCard(
                        context,
                        recentResults.first,
                        isEnglish ? 'PREVIOUS RESULTS' : 'MATOKEO YA AWALI',
                        true,
                        isEnglish,
                      )
                    : _buildEmptyMatchCard(
                        isEnglish ? 'NO RECENT RESULTS' : 'HAKUNA MATOKEO',
                        AppColors.primaryBlue,
                      ),
              ),

              const SizedBox(width: 16),

              // Next Match Card
              Expanded(
                child: upcomingFixtures.isNotEmpty
                    ? _buildMatchCard(
                        context,
                        upcomingFixtures.first,
                        isEnglish ? 'NEXT MATCH' : 'MECHI IJAYO',
                        false,
                        isEnglish,
                      )
                    : _buildEmptyMatchCard(
                        isEnglish
                            ? 'NO UPCOMING MATCHES'
                            : 'HAKUNA MECHI IJAYO',
                        AppColors.grey,
                      ),
              ),
            ],
          );
        },
      ),
    );
  }

  Widget _buildTabs(BuildContext context, bool isEnglish) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
      decoration: BoxDecoration(
        color: AppColors.surfaceBackground,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        children: [
          _buildTab(
            context,
            isEnglish ? 'UPCOMING MATCHES' : 'MECHI IJAYO',
            0,
            isEnglish,
          ),
          _buildTab(
            context,
            isEnglish ? 'MATCH RESULTS' : 'MATOKEO YA MECHI',
            1,
            isEnglish,
          ),
        ],
      ),
    );
  }

  Widget _buildTab(
      BuildContext context, String label, int index, bool isEnglish) {
    final isSelected = _selectedTabIndex == index;

    return Expanded(
      child: GestureDetector(
        onTap: () {
          setState(() {
            _selectedTabIndex = index;
          });
        },
        child: Container(
          padding: const EdgeInsets.symmetric(vertical: 16),
          decoration: BoxDecoration(
            color: isSelected
                ? BlueThemeColors.getPrimaryColor(ref.watch(blueThemeProvider))
                : Colors.transparent,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Text(
            label,
            style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                  color: isSelected ? AppColors.white : AppColors.textSecondary,
                  fontWeight: FontWeight.w600,
                  fontSize: 12,
                ),
            textAlign: TextAlign.center,
          ),
        ),
      ),
    );
  }

  Widget _buildUpcomingMatchesTab(BuildContext context, bool isEnglish) {
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
              color: AppColors.textLight,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish
                  ? 'Failed to load fixtures'
                  : 'Imeshindwa kupakia michuano',
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    color: AppColors.textLight,
                  ),
            ),
            const SizedBox(height: 8),
            TextButton(
              onPressed: () {
                ref.read(fixturesProvider.notifier).fetchUpcomingFixtures();
              },
              child: Text(
                isEnglish ? 'Retry' : 'Jaribu tena',
              ),
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
              color: AppColors.textLight,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish ? 'No upcoming matches' : 'Hakuna MECHI ijayo',
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    color: AppColors.textLight,
                  ),
            ),
          ],
        ),
      );
    }

    // Show only first 3 fixtures
    final limitedFixtures = upcomingFixtures.take(3).toList();

    return Column(
      children: [
        SizedBox(
          height: 300, // Fixed height to allow scrolling
          child: ListView.builder(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            itemCount: limitedFixtures.length,
            itemBuilder: (context, index) {
              final fixture = limitedFixtures[index];
              return Padding(
                padding: const EdgeInsets.only(bottom: 16),
                child: GestureDetector(
                  onTap: () {
                    AppRoutes.goToFixtureDetail(context, fixture.id.toString());
                  },
                  child: FixtureCard(
                    fixture: _convertFixtureToFixtureData(fixture),
                    isEnglish: isEnglish,
                  ).animate().fadeIn(
                        duration: const Duration(milliseconds: 600),
                        delay: Duration(milliseconds: index * 100),
                      ),
                ),
              );
            },
          ),
        ),
        if (upcomingFixtures.length > 3)
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
            child: Consumer(
              builder: (context, ref, child) {
                final blueTheme = ref.watch(blueThemeProvider);
                return TextButton(
                  onPressed: () {
                    AppRoutes.goToFixtures(context);
                  },
                  child: Text(
                    isEnglish ? 'View More Fixtures' : 'Ona Michuano Zaidi',
                    style: TextStyle(
                      color: BlueThemeColors.getPrimaryColor(blueTheme),
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                );
              },
            ),
          ),
      ],
    );
  }

  Widget _buildMatchResultsTab(BuildContext context, bool isEnglish) {
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
              color: AppColors.textLight,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish
                  ? 'Failed to load results'
                  : 'Imeshindwa kupakia matokeo',
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    color: AppColors.textLight,
                  ),
            ),
            const SizedBox(height: 8),
            TextButton(
              onPressed: () {
                ref.read(fixturesProvider.notifier).fetchRecentResults();
              },
              child: Text(
                isEnglish ? 'Retry' : 'Jaribu tena',
              ),
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
              color: AppColors.textLight,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish
                  ? 'No recent results'
                  : 'Hakuna matokeo ya hivi karibuni',
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    color: AppColors.textLight,
                  ),
            ),
          ],
        ),
      );
    }

    // Show only first 3 results
    final limitedResults = recentResults.take(3).toList();

    return Column(
      children: [
        SizedBox(
          height: 300, // Fixed height to allow scrolling
          child: ListView.builder(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            itemCount: limitedResults.length,
            itemBuilder: (context, index) {
              final fixture = limitedResults[index];
              return Padding(
                padding: const EdgeInsets.only(bottom: 16),
                child: GestureDetector(
                  onTap: () {
                    AppRoutes.goToFixtureDetail(context, fixture.id.toString());
                  },
                  child: FixtureCard(
                    fixture: _convertFixtureToFixtureData(fixture),
                    isEnglish: isEnglish,
                  ).animate().fadeIn(
                        duration: const Duration(milliseconds: 600),
                        delay: Duration(milliseconds: index * 100),
                      ),
                ),
              );
            },
          ),
        ),
        if (recentResults.length > 3)
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
            child: Consumer(
              builder: (context, ref, child) {
                final blueTheme = ref.watch(blueThemeProvider);
                return TextButton(
                  onPressed: () {
                    AppRoutes.goToFixtures(context);
                  },
                  child: Text(
                    isEnglish ? 'View More Results' : 'Ona Matokeo Zaidi',
                    style: TextStyle(
                      color: BlueThemeColors.getPrimaryColor(blueTheme),
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                );
              },
            ),
          ),
      ],
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

  // Helper method to build match card from fixture data
  Widget _buildMatchCard(BuildContext context, Fixture fixture, String title,
      bool isResult, bool isEnglish) {
    final dateFormat = DateFormat('EEE dd MMM');
    final timeFormat = DateFormat('HH:mm');

    return MatchCard(
      title: title,
      subtitle: fixture.tournament,
      date: dateFormat.format(fixture.matchDate),
      homeTeam: fixture.homeTeam,
      awayTeam: fixture.awayTeam,
      homeScore: fixture.homeScore,
      awayScore: fixture.awayScore,
      matchTime: isResult ? null : timeFormat.format(fixture.matchDate),
      isResult: isResult,
      backgroundColor: isResult ? AppColors.primaryBlue : AppColors.grey,
      homeTeamLogo: fixture.homeTeamLogo ?? '',
      awayTeamLogo: fixture.awayTeamLogo ?? '',
      venue: fixture.venue,
      scorers: isResult ? [] : null, // We don't have scorer data from API yet
    );
  }

  // Helper method to build empty match card
  Widget _buildEmptyMatchCard(String message, Color backgroundColor) {
    return Container(
      height: 180,
      decoration: BoxDecoration(
        color: backgroundColor.withOpacity(0.1),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: backgroundColor.withOpacity(0.3),
          width: 1,
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.sports_soccer,
              size: 48,
              color: backgroundColor.withOpacity(0.6),
            ),
            const SizedBox(height: 12),
            Text(
              message,
              style: TextStyle(
                color: backgroundColor.withOpacity(0.8),
                fontSize: 12,
                fontWeight: FontWeight.w600,
              ),
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
    );
  }
}
