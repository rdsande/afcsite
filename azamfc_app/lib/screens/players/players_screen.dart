import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../../constants/app_colors.dart';
import '../../constants/app_routes.dart';
import '../../providers/language_provider.dart';
import '../../providers/players_provider.dart';
import '../../models/player.dart';

class PlayersScreen extends ConsumerStatefulWidget {
  const PlayersScreen({super.key});

  @override
  ConsumerState<PlayersScreen> createState() => _PlayersScreenState();
}

class _PlayersScreenState extends ConsumerState<PlayersScreen> {
  @override
  void initState() {
    super.initState();
    // Fetch senior players on screen initialization
    WidgetsBinding.instance.addPostFrameCallback((_) {
      ref.read(playersProvider.notifier).fetchSeniorPlayers();
    });
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    final seniorPlayers = ref.watch(seniorPlayersProvider);
    final isLoading = ref.watch(playersLoadingProvider);
    final error = ref.watch(playersErrorProvider);
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      appBar: AppBar(
        title: Text(
          isEnglish ? 'Our Squad' : 'Timu Yetu',
        ),
      ),
      body: isLoading
          ? const Center(
              child: CircularProgressIndicator(),
            )
          : error != null
              ? Center(
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
                        isEnglish ? 'Error loading players' : 'Hitilafu katika kupakia wachezaji',
                        style: Theme.of(context).textTheme.titleLarge?.copyWith(
                          color: AppColors.error,
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
                          ref.read(playersProvider.notifier).fetchSeniorPlayers();
                        },
                        child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
                      ),
                    ],
                  ),
                )
              : seniorPlayers.isEmpty
                  ? Center(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(
                            Icons.people_outline,
                            size: 64,
                            color: AppColors.textSecondary,
                          ),
                          const SizedBox(height: 16),
                          Text(
                            isEnglish ? 'No players found' : 'Hakuna wachezaji',
                            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                              color: AppColors.textSecondary,
                            ),
                          ),
                        ],
                      ),
                    )
                  : ListView.builder(
                      padding: const EdgeInsets.all(16),
                      itemCount: seniorPlayers.keys.length,
                      itemBuilder: (context, index) {
                        final position = seniorPlayers.keys.elementAt(index);
                        final players = seniorPlayers[position]!;
                        return _buildPositionSection(position, players, isEnglish);
                      },
                    ),
    );
  }

  Widget _buildPositionSection(String position, List<Player> players, bool isEnglish) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Padding(
          padding: const EdgeInsets.symmetric(vertical: 16),
          child: Text(
            position,
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
              color: AppColors.primaryBlue,
              fontWeight: FontWeight.w700,
            ),
          ),
        ),
        ...players.map((player) => _buildPlayerCard(player, isEnglish)),
        const SizedBox(height: 16),
      ],
    );
  }

  Widget _buildPlayerCard(Player player, bool isEnglish) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: AppColors.shadowColorLight,
            blurRadius: 8,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: InkWell(
        onTap: () {
          AppRoutes.goToPlayerDetail(context, player.id.toString());
        },
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Row(
            children: [
              // Player Image
              Container(
                width: 60,
                height: 60,
                decoration: BoxDecoration(
                   shape: BoxShape.circle,
                   color: AppColors.lightGrey,
                 ),
                child: ClipOval(
                  child: player.image != null
                      ? CachedNetworkImage(
                          imageUrl: player.image!,
                          fit: BoxFit.cover,
                          placeholder: (context, url) => Container(
                             color: AppColors.lightGrey,
                             child: Icon(
                               Icons.person,
                               color: AppColors.textSecondary,
                               size: 30,
                             ),
                           ),
                          errorWidget: (context, url, error) => Container(
                             color: AppColors.lightGrey,
                             child: Icon(
                               Icons.person,
                               color: AppColors.textSecondary,
                               size: 30,
                             ),
                           ),
                        )
                      : Icon(
                          Icons.person,
                          color: AppColors.textSecondary,
                          size: 30,
                        ),
                ),
              ),
              const SizedBox(width: 16),
              // Player Info
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      player.name,
                      style: Theme.of(context).textTheme.titleMedium?.copyWith(
                        fontWeight: FontWeight.w600,
                        color: AppColors.textPrimary,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      player.position,
                      style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      '${isEnglish ? 'Jersey' : 'Jezi'}: #${player.jerseyNumber}',
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.primaryBlue,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                  ],
                ),
              ),
              // Nationality Flag or Icon
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: AppColors.primaryBlue.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Text(
                  player.nationality,
                  style: Theme.of(context).textTheme.bodySmall?.copyWith(
                    color: AppColors.primaryBlue,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
