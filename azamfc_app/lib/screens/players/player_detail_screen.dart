import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';

import '../../constants/app_colors.dart';
import '../../providers/language_provider.dart';
import '../../providers/players_provider.dart';
import '../../models/player.dart';

class PlayerDetailScreen extends ConsumerStatefulWidget {
  final String? playerId;

  const PlayerDetailScreen({super.key, this.playerId});

  @override
  ConsumerState<PlayerDetailScreen> createState() => _PlayerDetailScreenState();
}

class _PlayerDetailScreenState extends ConsumerState<PlayerDetailScreen> {
  Player? player;
  bool isLoading = true;
  String? error;

  @override
  void initState() {
    super.initState();
    _fetchPlayerDetail();
  }

  Future<void> _fetchPlayerDetail() async {
    if (widget.playerId == null) {
      setState(() {
        error = 'Player ID not provided';
        isLoading = false;
      });
      return;
    }

    try {
      final playerId = int.parse(widget.playerId!);
      final playerDetail = await ref.read(playersProvider.notifier).getPlayerDetail(playerId);
      
      setState(() {
        player = playerDetail;
        isLoading = false;
        error = playerDetail == null ? 'Player not found' : null;
      });
    } catch (e) {
      setState(() {
        error = 'Error loading player details';
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
          isEnglish ? 'Player Profile' : 'Wasifu wa Mchezaji',
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
                        isEnglish ? 'Error loading player' : 'Hitilafu katika kupakia mchezaji',
                        style: Theme.of(context).textTheme.titleLarge?.copyWith(
                          color: AppColors.error,
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
                        onPressed: _fetchPlayerDetail,
                        child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
                      ),
                    ],
                  ),
                )
              : player == null
                  ? Center(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(
                            Icons.person_outline,
                            size: 64,
                            color: AppColors.textSecondary,
                          ),
                          const SizedBox(height: 16),
                          Text(
                            isEnglish ? 'Player not found' : 'Mchezaji hajapatikana',
                            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                              color: AppColors.textSecondary,
                            ),
                          ),
                        ],
                      ),
                    )
                  : SingleChildScrollView(
                      padding: const EdgeInsets.all(16),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Player Header Card
                          Container(
                            width: double.infinity,
                            padding: const EdgeInsets.all(24),
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
                                // Player Image
                                Container(
                                  width: 120,
                                  height: 120,
                                  decoration: BoxDecoration(
                                    shape: BoxShape.circle,
                                    color: AppColors.lightGrey,
                                  ),
                                  child: ClipOval(
                                    child: player!.image != null
                                        ? CachedNetworkImage(
                                            imageUrl: player!.image!,
                                            fit: BoxFit.cover,
                                            placeholder: (context, url) => Container(
                                              color: AppColors.lightGrey,
                                              child: Icon(
                                                Icons.person,
                                                color: AppColors.textSecondary,
                                                size: 60,
                                              ),
                                            ),
                                            errorWidget: (context, url, error) => Container(
                                              color: AppColors.lightGrey,
                                              child: Icon(
                                                Icons.person,
                                                color: AppColors.textSecondary,
                                                size: 60,
                                              ),
                                            ),
                                          )
                                        : Icon(
                                            Icons.person,
                                            color: AppColors.textSecondary,
                                            size: 60,
                                          ),
                                  ),
                                ),
                                const SizedBox(height: 16),
                                // Player Name
                                Text(
                                  player!.name,
                                  style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                                    fontWeight: FontWeight.w700,
                                    color: AppColors.textPrimary,
                                  ),
                                  textAlign: TextAlign.center,
                                ),
                                const SizedBox(height: 8),
                                // Position and Jersey Number
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    Container(
                                      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                                      decoration: BoxDecoration(
                                        color: AppColors.primaryBlue,
                                        borderRadius: BorderRadius.circular(20),
                                      ),
                                      child: Text(
                                        player!.position,
                                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                          color: AppColors.white,
                                          fontWeight: FontWeight.w600,
                                        ),
                                      ),
                                    ),
                                    const SizedBox(width: 12),
                                    Container(
                                      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                                      decoration: BoxDecoration(
                                        color: AppColors.secondaryGold,
                                        borderRadius: BorderRadius.circular(20),
                                      ),
                                      child: Text(
                                        '#${player!.jerseyNumber}',
                                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                          color: AppColors.white,
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
                          // Player Details
                          Container(
                            width: double.infinity,
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
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  isEnglish ? 'Player Information' : 'Taarifa za Mchezaji',
                                  style: Theme.of(context).textTheme.titleLarge?.copyWith(
                                    fontWeight: FontWeight.w700,
                                    color: AppColors.primaryBlue,
                                  ),
                                ),
                                const SizedBox(height: 16),
                                _buildInfoRow(
                                  isEnglish ? 'Nationality' : 'Utaifa',
                                  player!.nationality,
                                  context,
                                ),
                                _buildInfoRow(
                                  isEnglish ? 'Date of Birth' : 'Tarehe ya Kuzaliwa',
                                  DateFormat('MMM dd, yyyy').format(player!.dateOfBirth),
                                  context,
                                ),
                                if (player!.height != null)
                                  _buildInfoRow(
                                    isEnglish ? 'Height' : 'Urefu',
                                    player!.height!,
                                    context,
                                  ),
                                if (player!.weight != null)
                                  _buildInfoRow(
                                    isEnglish ? 'Weight' : 'Uzito',
                                    player!.weight!,
                                    context,
                                  ),
                                if (player!.team != null)
                                  _buildInfoRow(
                                    isEnglish ? 'Team Category' : 'Kundi la Timu',
                                    player!.team!,
                                    context,
                                  ),
                                _buildInfoRow(
                                  isEnglish ? 'Status' : 'Hali',
                                  player!.isActive 
                                      ? (isEnglish ? 'Active' : 'Hai') 
                                      : (isEnglish ? 'Inactive' : 'Hahai'),
                                  context,
                                ),
                              ],
                            ),
                          ),
                          // Biography Section
                           if (player!.bio != null && player!.bio!.isNotEmpty) ...[
                             const SizedBox(height: 24),
                            Container(
                              width: double.infinity,
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
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    isEnglish ? 'Biography' : 'Wasifu',
                                    style: Theme.of(context).textTheme.titleLarge?.copyWith(
                                      fontWeight: FontWeight.w700,
                                      color: AppColors.primaryBlue,
                                    ),
                                  ),
                                  const SizedBox(height: 12),
                                  Text(
                                    player!.bio!,
                                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                      color: AppColors.textPrimary,
                                      height: 1.6,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        ],
                      ),
                    ),
    );
  }

  Widget _buildInfoRow(String label, String value, BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          SizedBox(
            width: 120,
            child: Text(
              label,
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                color: AppColors.textSecondary,
                fontWeight: FontWeight.w500,
              ),
            ),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Text(
              value,
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                color: AppColors.textPrimary,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
