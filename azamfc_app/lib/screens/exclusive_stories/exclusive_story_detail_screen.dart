import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';
import 'package:webview_flutter/webview_flutter.dart';
import 'package:url_launcher/url_launcher.dart';

import '../../constants/app_colors.dart';
import '../../providers/language_provider.dart';
import '../../providers/theme_provider.dart';
import '../../providers/exclusive_stories_provider.dart';
import '../../models/exclusive_story.dart';
import '../../widgets/detail_screen_wrapper.dart';

class ExclusiveStoryDetailScreen extends ConsumerStatefulWidget {
  final String storyId;

  const ExclusiveStoryDetailScreen({
    super.key,
    required this.storyId,
  });

  @override
  ConsumerState<ExclusiveStoryDetailScreen> createState() =>
      _ExclusiveStoryDetailScreenState();
}

class _ExclusiveStoryDetailScreenState
    extends ConsumerState<ExclusiveStoryDetailScreen> {
  ExclusiveStory? story;
  bool isLoading = true;
  String? error;

  @override
  void initState() {
    super.initState();
    _loadStoryDetail();
  }

  Future<void> _loadStoryDetail() async {
    try {
      setState(() {
        isLoading = true;
        error = null;
      });

      final storyDetail = await ref
          .read(exclusiveStoriesProvider.notifier)
          .getStoryDetail(int.parse(widget.storyId));

      if (mounted) {
        setState(() {
          story = storyDetail;
          isLoading = false;
        });
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          error = e.toString();
          isLoading = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final locale = ref.watch(languageProviderProvider);
    final isEnglish = locale.languageCode == 'en';
    final blueTheme = ref.watch(blueThemeProvider);

    return DetailScreenWrapper(
      title: isEnglish ? 'Exclusive Story' : 'Hadithi ya Kipekee',
      child: _buildContent(context, isEnglish, blueTheme),
    );
  }

  Widget _buildContent(BuildContext context, bool isEnglish, BlueTheme blueTheme) {
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
              color: AppColors.textSecondary,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish ? 'Failed to load story' : 'Imeshindwa kupakia hadithi',
              style: Theme.of(context).textTheme.titleLarge?.copyWith(
                color: AppColors.textSecondary,
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
              onPressed: _loadStoryDetail,
              child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
            ),
          ],
        ),
      );
    }

    if (story == null) {
      return Center(
        child: Text(
          isEnglish ? 'Story not found' : 'Hadithi haijapatikana',
          style: Theme.of(context).textTheme.titleLarge?.copyWith(
            color: AppColors.textSecondary,
            fontWeight: FontWeight.w600,
          ),
        ),
      );
    }

    return SingleChildScrollView(
      padding: const EdgeInsets.all(24),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Story Header
          _buildStoryHeader(context, isEnglish, blueTheme),
          const SizedBox(height: 24),
          
          // Media Gallery
          _buildMediaGallery(context, isEnglish, blueTheme),
          const SizedBox(height: 24),
          
          // Story Description
          if (story!.description != null && story!.description!.isNotEmpty)
            _buildDescription(context, isEnglish),
        ],
      ),
    );
  }

  Widget _buildStoryHeader(BuildContext context, bool isEnglish, BlueTheme blueTheme) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // Type Badge
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
          decoration: BoxDecoration(
            color: story!.type == 'video'
                ? Colors.red.withOpacity(0.1)
                : Colors.blue.withOpacity(0.1),
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            story!.type == 'video'
                ? (isEnglish ? 'VIDEO STORY' : 'HADITHI YA VIDEO')
                : (isEnglish ? 'PHOTO GALLERY' : 'MKUSANYIKO WA PICHA'),
            style: TextStyle(
              color: story!.type == 'video' ? Colors.red : Colors.blue,
              fontSize: 12,
              fontWeight: FontWeight.w700,
            ),
          ),
        ),
        const SizedBox(height: 16),
        
        // Title
        Text(
          story!.title,
          style: Theme.of(context).textTheme.headlineSmall?.copyWith(
            color: AppColors.textPrimary,
            fontWeight: FontWeight.w700,
          ),
        ),
        const SizedBox(height: 12),
        
        // Meta Information
        Row(
          children: [
            Icon(
              Icons.access_time,
              size: 16,
              color: AppColors.textSecondary,
            ),
            const SizedBox(width: 4),
            Text(
              DateFormat('MMM dd, yyyy').format(story!.createdAt),
              style: Theme.of(context).textTheme.bodySmall?.copyWith(
                color: AppColors.textSecondary,
              ),
            ),
            const SizedBox(width: 16),
            Icon(
              story!.type == 'video' ? Icons.videocam : Icons.photo_library,
              size: 16,
              color: AppColors.textSecondary,
            ),
            const SizedBox(width: 4),
            Text(
              '${story!.mediaCount} ${story!.type == 'video' ? (isEnglish ? 'videos' : 'video') : (isEnglish ? 'photos' : 'picha')}',
              style: Theme.of(context).textTheme.bodySmall?.copyWith(
                color: AppColors.textSecondary,
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildMediaGallery(BuildContext context, bool isEnglish, BlueTheme blueTheme) {
    if (story!.media == null || story!.media!.isEmpty) {
      return Container(
        height: 200,
        decoration: BoxDecoration(
          color: AppColors.surfaceBackground,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                story!.type == 'video' ? Icons.videocam_off : Icons.photo_library_outlined,
                size: 48,
                color: AppColors.textSecondary,
              ),
              const SizedBox(height: 8),
              Text(
                isEnglish ? 'No media available' : 'Hakuna media inayopatikana',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppColors.textSecondary,
                ),
              ),
            ],
          ),
        ),
      );
    }

    if (story!.type == 'video') {
      return _buildVideoGallery(context, isEnglish);
    } else {
      return _buildPhotoGallery(context, isEnglish);
    }
  }

  Widget _buildPhotoGallery(BuildContext context, bool isEnglish) {
    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        crossAxisSpacing: 12,
        mainAxisSpacing: 12,
        childAspectRatio: 1.2,
      ),
      itemCount: story!.media!.length,
      itemBuilder: (context, index) {
        final media = story!.media![index];
        return GestureDetector(
          onTap: () {
            _showImageViewer(context, index);
          },
          child: Container(
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  blurRadius: 8,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.circular(12),
              child: CachedNetworkImage(
                imageUrl: media.url,
                fit: BoxFit.cover,
                placeholder: (context, url) => Container(
                  color: AppColors.surfaceBackground,
                  child: const Center(
                    child: CircularProgressIndicator(),
                  ),
                ),
                errorWidget: (context, url, error) => Container(
                  color: AppColors.surfaceBackground,
                  child: Icon(
                    Icons.broken_image,
                    color: AppColors.textSecondary,
                    size: 32,
                  ),
                ),
              ),
            ),
          ),
        );
      },
    );
  }

  Widget _buildVideoGallery(BuildContext context, bool isEnglish) {
    return Column(
      children: [
        // Embedded video from YouTube/Vimeo if available
         if (story!.hasVideoLink)
           Container(
            margin: const EdgeInsets.only(bottom: 16),
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(12),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.1),
                  blurRadius: 8,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.circular(12),
              child: AspectRatio(
                aspectRatio: 16 / 9,
                child: story!.embedUrl != null
                    ? WebViewWidget(
                        controller: WebViewController()
                          ..setJavaScriptMode(JavaScriptMode.unrestricted)
                          ..loadRequest(Uri.parse(story!.embedUrl!)),
                      )
                    : Container(
                        color: AppColors.surfaceBackground,
                        child: Center(
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons.video_library_outlined,
                                size: 48,
                                color: AppColors.textSecondary,
                              ),
                              const SizedBox(height: 8),
                              Text(
                                isEnglish ? 'Unable to embed video' : 'Haiwezi kuingiza video',
                                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                  color: AppColors.textSecondary,
                                ),
                              ),
                              const SizedBox(height: 8),
                              TextButton(
                                onPressed: () async {
                                  final uri = Uri.parse(story!.videoLink!);
                                  if (await canLaunchUrl(uri)) {
                                    await launchUrl(uri, mode: LaunchMode.externalApplication);
                                  }
                                },
                                child: Text(
                                  isEnglish ? 'Watch on Platform' : 'Tazama kwenye Jukwaa',
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
               ),
             ),
           ),
         
         // Regular media files
         ...story!.media!.map((media) {
          return GestureDetector(
            onTap: () async {
              // Try to open the video file directly
              final uri = Uri.parse(media.url);
              if (await canLaunchUrl(uri)) {
                await launchUrl(uri, mode: LaunchMode.externalApplication);
              } else {
                // Show error message if video cannot be opened
                if (context.mounted) {
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(
                      content: Text(
                        isEnglish ? 'Unable to open video' : 'Haiwezi kufungua video',
                      ),
                      backgroundColor: Colors.red,
                    ),
                  );
                }
              }
            },
            child: Container(
              margin: const EdgeInsets.only(bottom: 16),
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(12),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.1),
                    blurRadius: 8,
                    offset: const Offset(0, 2),
                  ),
                ],
              ),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(12),
                child: AspectRatio(
                  aspectRatio: 16 / 9,
                  child: Stack(
                    children: [
                      // Video thumbnail
                      CachedNetworkImage(
                        imageUrl: story!.thumbnail?.url ?? media.url,
                        fit: BoxFit.cover,
                        width: double.infinity,
                        height: double.infinity,
                        placeholder: (context, url) => Container(
                          color: AppColors.surfaceBackground,
                          child: const Center(
                            child: CircularProgressIndicator(),
                          ),
                        ),
                        errorWidget: (context, url, error) => Container(
                          color: AppColors.surfaceBackground,
                          child: Icon(
                            Icons.videocam,
                            color: AppColors.textSecondary,
                            size: 48,
                          ),
                        ),
                      ),
                      // Play button overlay
                      Center(
                        child: Container(
                          padding: const EdgeInsets.all(16),
                          decoration: BoxDecoration(
                            color: Colors.black.withOpacity(0.7),
                            shape: BoxShape.circle,
                          ),
                          child: const Icon(
                            Icons.play_arrow,
                            color: Colors.white,
                            size: 32,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          );
        }).toList(),
      ],
    );
  }

  Widget _buildDescription(BuildContext context, bool isEnglish) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          isEnglish ? 'Description' : 'Maelezo',
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            color: AppColors.textPrimary,
            fontWeight: FontWeight.w700,
          ),
        ),
        const SizedBox(height: 12),
        Container(
          padding: const EdgeInsets.all(16),
          decoration: BoxDecoration(
            color: AppColors.surfaceBackground,
            borderRadius: BorderRadius.circular(12),
          ),
          child: Text(
            story!.description!,
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: AppColors.textPrimary,
              height: 1.6,
            ),
          ),
        ),
      ],
    );
  }

  void _showImageViewer(BuildContext context, int initialIndex) {
    showDialog(
      context: context,
      builder: (context) => Dialog(
        backgroundColor: Colors.black,
        child: Stack(
          children: [
            PageView.builder(
              controller: PageController(initialPage: initialIndex),
              itemCount: story!.media!.length,
              itemBuilder: (context, index) {
                final media = story!.media![index];
                return InteractiveViewer(
                  child: CachedNetworkImage(
                    imageUrl: media.url,
                    fit: BoxFit.contain,
                    placeholder: (context, url) => const Center(
                      child: CircularProgressIndicator(color: Colors.white),
                    ),
                    errorWidget: (context, url, error) => const Center(
                      child: Icon(
                        Icons.broken_image,
                        color: Colors.white,
                        size: 64,
                      ),
                    ),
                  ),
                );
              },
            ),
            Positioned(
              top: 16,
              right: 16,
              child: IconButton(
                onPressed: () => Navigator.of(context).pop(),
                icon: const Icon(
                  Icons.close,
                  color: Colors.white,
                  size: 32,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}