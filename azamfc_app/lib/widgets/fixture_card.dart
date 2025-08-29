import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../constants/app_colors.dart';
import 'cached_image_widget.dart';

class FixtureCard extends StatelessWidget {
  final FixtureData fixture;
  final bool isEnglish;

  const FixtureCard({
    super.key,
    required this.fixture,
    required this.isEnglish,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: AppColors.shadowColorLight,
            blurRadius: 20,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Column(
        children: [
          // Teams Row
          Row(
            children: [
              // Home Team
              Expanded(
                child: _buildTeamSection(
                  fixture.homeTeam,
                  fixture.homeTeamLogo,
                  true,
                  context,
                ),
              ),
              
              // VS or Score
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                decoration: BoxDecoration(
                  color: AppColors.primaryBlue.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: fixture.homeScore != null && fixture.awayScore != null
                    ? Text(
                        '${fixture.homeScore} - ${fixture.awayScore}',
                        style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          color: AppColors.primaryBlue,
                          fontWeight: FontWeight.w700,
                        ),
                      )
                    : Text(
                        'VS',
                        style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          color: AppColors.primaryBlue,
                          fontWeight: FontWeight.w700,
                        ),
                      ),
              ),
              
              // Away Team
              Expanded(
                child: _buildTeamSection(
                  fixture.awayTeam,
                  fixture.awayTeamLogo,
                  false,
                  context,
                ),
              ),
            ],
          ),
          
          const SizedBox(height: 8),
          
          // Competition and Details - Compact Single Row
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 6),
            decoration: BoxDecoration(
              color: AppColors.surfaceBackground,
              borderRadius: BorderRadius.circular(8),
            ),
            child: Column(
              children: [
                // Competition
                Text(
                  fixture.competition,
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.textPrimary,
                    fontWeight: FontWeight.w700,
                    fontSize: 12,
                  ),
                  textAlign: TextAlign.center,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                ),
                
                const SizedBox(height: 4),
                
                // Date and Stadium in Two Columns
                Row(
                  children: [
                    // Left Column - Date and Time
                    Expanded(
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(
                            Icons.access_time,
                            size: 12,
                            color: AppColors.textSecondary,
                          ),
                          const SizedBox(width: 4),
                          Flexible(
                            child: Text(
                              '${fixture.time} ${fixture.date}',
                              style: Theme.of(context).textTheme.bodySmall?.copyWith(
                                color: AppColors.textSecondary,
                                fontWeight: FontWeight.w500,
                                fontSize: 10,
                              ),
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                            ),
                          ),
                        ],
                      ),
                    ),
                    
                    // Divider
                    Container(
                      width: 1,
                      height: 16,
                      color: AppColors.textSecondary.withOpacity(0.3),
                      margin: const EdgeInsets.symmetric(horizontal: 8),
                    ),
                    
                    // Right Column - Stadium
                    Expanded(
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(
                            Icons.location_on,
                            size: 12,
                            color: AppColors.textSecondary,
                          ),
                          const SizedBox(width: 4),
                          Flexible(
                            child: Text(
                              fixture.venue,
                              style: Theme.of(context).textTheme.bodySmall?.copyWith(
                                color: AppColors.textSecondary,
                                fontWeight: FontWeight.w500,
                                fontSize: 10,
                              ),
                              textAlign: TextAlign.center,
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTeamSection(String teamName, String logoPath, bool isHome, BuildContext context) {
    return Column(
      children: [
        // Team Logo
        Container(
          width: 45,
          height: 45,
          decoration: BoxDecoration(
            color: AppColors.white,
            shape: BoxShape.circle,
            boxShadow: [
              BoxShadow(
                color: AppColors.shadowColor,
                blurRadius: 15,
                offset: const Offset(0, 8),
              ),
            ],
          ),
          child: ClipOval(
            child: _buildTeamLogo(logoPath),
          ),
        ),
        
        const SizedBox(height: 6),
        
        // Team Name
        Text(
          teamName,
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            color: AppColors.textPrimary,
            fontWeight: FontWeight.w700,
            fontSize: 11, // Reduced font size
          ),
          textAlign: TextAlign.center,
          maxLines: 2,
          overflow: TextOverflow.ellipsis,
        ),
      ],
    );
  }

  Widget _buildTeamLogo(String logoPath) {
    return TeamLogoWidget(
      logoUrl: logoPath,
      size: 40,
    );
  }
}

// This should match the FixtureData class from home_screen.dart
class FixtureData {
  final String homeTeam;
  final String awayTeam;
  final String competition;
  final String date;
  final String time;
  final String venue;
  final String homeTeamLogo;
  final String awayTeamLogo;
  final int? homeScore;
  final int? awayScore;

  FixtureData({
    required this.homeTeam,
    required this.awayTeam,
    required this.competition,
    required this.date,
    required this.time,
    required this.venue,
    required this.homeTeamLogo,
    required this.awayTeamLogo,
    this.homeScore,
    this.awayScore,
  });
}
