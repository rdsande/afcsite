import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../constants/app_colors.dart';

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
      padding: const EdgeInsets.all(20),
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
          
          const SizedBox(height: 20),
          
          // Competition and Details
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: AppColors.surfaceBackground,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Column(
              children: [
                // Competition
                Text(
                  fixture.competition,
                  style: Theme.of(context).textTheme.titleMedium?.copyWith(
                    color: AppColors.textPrimary,
                    fontWeight: FontWeight.w700,
                  ),
                  textAlign: TextAlign.center,
                ),
                
                const SizedBox(height: 12),
                
                // Time and Date
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(
                      Icons.access_time,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 8),
                    Text(
                      '${fixture.time} ${fixture.date}',
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.textSecondary,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
                
                const SizedBox(height: 8),
                
                // Venue
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(
                      Icons.location_on,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 8),
                    Expanded(
                      child: Text(
                        fixture.venue,
                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                          color: AppColors.textSecondary,
                          fontWeight: FontWeight.w500,
                        ),
                        textAlign: TextAlign.center,
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
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
          width: 60,
          height: 60,
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
        
        const SizedBox(height: 12),
        
        // Team Name
        Text(
          teamName,
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            color: AppColors.textPrimary,
            fontWeight: FontWeight.w700,
          ),
          textAlign: TextAlign.center,
          maxLines: 2,
          overflow: TextOverflow.ellipsis,
        ),
      ],
    );
  }

  Widget _buildTeamLogo(String logoPath) {
    // If logoPath is empty or null, show placeholder
    if (logoPath.isEmpty) {
      return Container(
        color: AppColors.lightGrey,
        child: const Icon(
          Icons.sports_soccer,
          color: AppColors.grey,
          size: 30,
        ),
      );
    }
    
    if (logoPath.startsWith('http')) {
      return CachedNetworkImage(
        imageUrl: logoPath,
        fit: BoxFit.cover,
        placeholder: (context, url) => Container(
          color: AppColors.lightGrey,
          child: const Icon(
            Icons.sports_soccer,
            color: AppColors.grey,
            size: 30,
          ),
        ),
        errorWidget: (context, url, error) => Container(
          color: AppColors.lightGrey,
          child: const Icon(
            Icons.sports_soccer,
            color: AppColors.grey,
            size: 30,
          ),
        ),
      );
    } else {
      // Local asset - but since we don't have assets, show placeholder
      return Container(
        color: AppColors.lightGrey,
        child: const Icon(
          Icons.sports_soccer,
          color: AppColors.grey,
          size: 30,
        ),
      );
    }
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
