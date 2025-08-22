import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../constants/app_colors.dart';
import 'cached_image_widget.dart';

class MatchCard extends StatelessWidget {
  final String title;
  final String subtitle;
  final String date;
  final String homeTeam;
  final String awayTeam;
  final int? homeScore;
  final int? awayScore;
  final String? matchTime;
  final bool isResult;
  final Color backgroundColor;
  final String homeTeamLogo;
  final String awayTeamLogo;
  final List<String>? scorers;
  final String? venue;

  const MatchCard({
    super.key,
    required this.title,
    required this.subtitle,
    required this.date,
    required this.homeTeam,
    required this.awayTeam,
    this.homeScore,
    this.awayScore,
    this.matchTime,
    required this.isResult,
    required this.backgroundColor,
    required this.homeTeamLogo,
    required this.awayTeamLogo,
    this.scorers,
    this.venue,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: backgroundColor,
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
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Header
          Text(
            title,
            style: Theme.of(context).textTheme.bodySmall?.copyWith(
              color: AppColors.white,
              fontWeight: FontWeight.w700,
              letterSpacing: 0.5,
              fontSize: 11,
            ),
          ),
          const SizedBox(height: 2),
          Text(
            subtitle,
            style: Theme.of(context).textTheme.bodySmall?.copyWith(
              color: AppColors.white.withOpacity(0.9),
              fontWeight: FontWeight.w500,
              fontSize: 10,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            date,
            style: Theme.of(context).textTheme.bodySmall?.copyWith(
              color: AppColors.white.withOpacity(0.8),
              fontWeight: FontWeight.w400,
              fontSize: 9,
            ),
          ),
          
          const SizedBox(height: 16),
          
          // Teams and Score
          Row(
            children: [
              // Home Team
              Expanded(
                child: _buildTeamSection(
                  homeTeam,
                  homeTeamLogo,
                  true,
                  context,
                ),
              ),
              
              // Score/Time
              Expanded(
                child: _buildScoreSection(context),
              ),
              
              // Away Team
              Expanded(
                child: _buildTeamSection(
                  awayTeam,
                  awayTeamLogo,
                  false,
                  context,
                ),
              ),
            ],
          ),
          
          // Additional Info
          if (scorers != null && scorers!.isNotEmpty) ...[
            const SizedBox(height: 12),
            _buildScorersSection(context),
          ],
        ],
      ),
    );
  }

  Widget _buildTeamSection(String teamName, String logoPath, bool isHome, BuildContext context) {
    return Column(
      children: [
        // Team Logo
        Container(
          width: 40,
          height: 40,
          decoration: BoxDecoration(
            color: AppColors.white,
            shape: BoxShape.circle,
            boxShadow: [
              BoxShadow(
                color: AppColors.shadowColor,
                blurRadius: 10,
                offset: const Offset(0, 5),
              ),
            ],
          ),
          child: ClipOval(
            child: _buildTeamLogo(logoPath),
          ),
        ),
        
        const SizedBox(height: 8),
        
        // Team Name
        Text(
          teamName,
          style: Theme.of(context).textTheme.bodySmall?.copyWith(
            color: AppColors.white,
            fontWeight: FontWeight.w600,
            fontSize: 8,
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
      size: 32,
    );
  }

  Widget _buildScoreSection(BuildContext context) {
    return Column(
      children: [
        if (isResult) ...[
          // Score
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                '${homeScore ?? 0}',
                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  color: AppColors.white,
                  fontWeight: FontWeight.w900,
                  fontSize: 20,
                ),
              ),
              const SizedBox(width: 6),
              Text(
                '${awayScore ?? 0}',
                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  color: AppColors.white,
                  fontWeight: FontWeight.w900,
                  fontSize: 20,
                ),
              ),
            ],
          ),
        ] else ...[
          // Match Time
          Text(
            matchTime ?? 'TBD',
            style: Theme.of(context).textTheme.titleMedium?.copyWith(
              color: AppColors.white,
              fontWeight: FontWeight.w900,
              fontSize: 14,
            ),
          ),
        ],
        
        const SizedBox(height: 4),
        
        // VS or Result indicator
        Text(
          isResult ? 'FT' : 'VS',
          style: Theme.of(context).textTheme.bodySmall?.copyWith(
            color: AppColors.white.withOpacity(0.8),
            fontWeight: FontWeight.w500,
          ),
        ),
      ],
    );
  }

  Widget _buildScorersSection(BuildContext context) {
    return Row(
      children: [
        Icon(
          Icons.sports_soccer,
          size: 16,
          color: AppColors.white.withOpacity(0.8),
        ),
        const SizedBox(width: 8),
        Expanded(
          child: Text(
            scorers!.join(', '),
            style: Theme.of(context).textTheme.bodySmall?.copyWith(
              color: AppColors.white.withOpacity(0.9),
              fontWeight: FontWeight.w500,
            ),
            maxLines: 1,
            overflow: TextOverflow.ellipsis,
          ),
        ),
      ],
    );
  }

}
