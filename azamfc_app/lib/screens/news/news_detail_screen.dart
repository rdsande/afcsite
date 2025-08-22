import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';
import 'package:flutter_html/flutter_html.dart';

import '../../constants/app_colors.dart';
import '../../providers/language_provider.dart';
import '../../providers/news_provider.dart';
import '../../models/news.dart';
import '../../widgets/detail_screen_wrapper.dart';

class NewsDetailScreen extends ConsumerStatefulWidget {
  final String? newsId;

  const NewsDetailScreen({super.key, this.newsId});

  @override
  ConsumerState<NewsDetailScreen> createState() => _NewsDetailScreenState();
}

class _NewsDetailScreenState extends ConsumerState<NewsDetailScreen> {
  News? newsArticle;
  bool isLoading = true;
  String? error;

  @override
  void initState() {
    super.initState();
    _loadNewsDetail();
  }

  Future<void> _loadNewsDetail() async {
    if (widget.newsId == null) {
      setState(() {
        error = 'Invalid news ID';
        isLoading = false;
      });
      return;
    }

    try {
      final newsId = int.parse(widget.newsId!);
      final news = await ref.read(newsProvider.notifier).getNewsDetail(newsId);
      
      setState(() {
        newsArticle = news;
        isLoading = false;
        error = news == null ? 'News article not found' : null;
      });
    } catch (e) {
      setState(() {
        error = 'Failed to load news: $e';
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    
    return DetailScreenWrapper(
      title: 'News Detail',
      titleSw: 'Maelezo ya Habari',
      child: _buildBody(context, isEnglish),
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
              isEnglish ? 'Failed to load news' : 'Imeshindwa kupakia habari',
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
              onPressed: _loadNewsDetail,
              child: Text(isEnglish ? 'Retry' : 'Jaribu Tena'),
            ),
          ],
        ),
      );
    }

    if (newsArticle == null) {
      return Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.newspaper,
              size: 64,
              color: AppColors.textSecondary,
            ),
            const SizedBox(height: 16),
            Text(
              isEnglish ? 'News article not found' : 'Makala ya habari haijapatikana',
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
          // News Image
          if (newsArticle!.image != null && newsArticle!.image!.isNotEmpty)
            AspectRatio(
              aspectRatio: 16 / 9,
              child: CachedNetworkImage(
                imageUrl: newsArticle!.image!,
                fit: BoxFit.cover,
                placeholder: (context, url) => Container(
                  color: AppColors.lightGrey,
                  child: const Center(
                    child: CircularProgressIndicator(),
                  ),
                ),
                errorWidget: (context, url, error) => Container(
                  color: AppColors.lightGrey,
                  child: const Icon(
                    Icons.image_not_supported,
                    size: 48,
                    color: AppColors.grey,
                  ),
                ),
              ),
            ),
          
          // Content
          Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Category
                if (newsArticle!.category.isNotEmpty)
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                    decoration: BoxDecoration(
                      color: AppColors.primaryBlue.withOpacity(0.1),
                      borderRadius: BorderRadius.circular(16),
                    ),
                    child: Text(
                      newsArticle!.category.toUpperCase(),
                      style: Theme.of(context).textTheme.labelMedium?.copyWith(
                        color: AppColors.primaryBlue,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                
                const SizedBox(height: 16),
                
                // Title
                Text(
                  newsArticle!.title,
                  style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                    fontWeight: FontWeight.w700,
                    color: AppColors.textPrimary,
                    height: 1.3,
                  ),
                ),
                
                const SizedBox(height: 16),
                
                // Meta information
                Row(
                  children: [
                    Icon(
                      Icons.access_time,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      DateFormat('MMM dd, yyyy • HH:mm').format(newsArticle!.publishedAt),
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                    if (newsArticle!.author.isNotEmpty) ...[
                      const SizedBox(width: 16),
                      Icon(
                        Icons.person,
                        size: 16,
                        color: AppColors.textSecondary,
                      ),
                      const SizedBox(width: 4),
                      Expanded(
                        child: Text(
                          newsArticle!.author,
                          style: Theme.of(context).textTheme.bodySmall?.copyWith(
                            color: AppColors.textSecondary,
                          ),
                          overflow: TextOverflow.ellipsis,
                        ),
                      ),
                    ],
                  ],
                ),
                
                const SizedBox(height: 8),
                
                // Views
                Row(
                  children: [
                    Icon(
                      Icons.visibility,
                      size: 16,
                      color: AppColors.textSecondary,
                    ),
                    const SizedBox(width: 4),
                    Text(
                      '${newsArticle!.views} ${isEnglish ? 'views' : 'mionzi'}',
                      style: Theme.of(context).textTheme.bodySmall?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                  ],
                ),
                
                const SizedBox(height: 24),
                
                // Content
                Html(
                  data: newsArticle!.content,
                  style: {
                    "body": Style(
                      margin: Margins.zero,
                      padding: HtmlPaddings.zero,
                      fontSize: FontSize(16),
                      lineHeight: LineHeight(1.6),
                      color: AppColors.textPrimary,
                    ),
                    "p": Style(
                      margin: Margins.only(bottom: 16),
                      fontSize: FontSize(16),
                      lineHeight: LineHeight(1.6),
                      color: AppColors.textPrimary,
                    ),
                    "h1, h2, h3, h4, h5, h6": Style(
                      fontWeight: FontWeight.bold,
                      color: AppColors.textPrimary,
                      margin: Margins.only(top: 16, bottom: 8),
                    ),
                    "a": Style(
                      color: AppColors.primaryBlue,
                      textDecoration: TextDecoration.underline,
                    ),
                    "strong, b": Style(
                      fontWeight: FontWeight.bold,
                    ),
                    "em, i": Style(
                      fontStyle: FontStyle.italic,
                    ),
                    "ul, ol": Style(
                      margin: Margins.only(bottom: 16),
                      padding: HtmlPaddings.only(left: 20),
                    ),
                    "li": Style(
                      margin: Margins.only(bottom: 4),
                    ),
                  },
                ),
                
                const SizedBox(height: 32),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
