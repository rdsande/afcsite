import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../constants/app_colors.dart';
import '../utils/image_utils.dart';

class CachedImageWidget extends StatelessWidget {
  final String? imageUrl;
  final double? width;
  final double? height;
  final BoxFit fit;
  final BorderRadius? borderRadius;
  final IconData fallbackIcon;
  final double fallbackIconSize;
  final Color? fallbackIconColor;
  final Color? backgroundColor;
  final bool isCircular;

  const CachedImageWidget({
    super.key,
    required this.imageUrl,
    this.width,
    this.height,
    this.fit = BoxFit.cover,
    this.borderRadius,
    this.fallbackIcon = Icons.image,
    this.fallbackIconSize = 30,
    this.fallbackIconColor,
    this.backgroundColor,
    this.isCircular = false,
  });

  @override
  Widget build(BuildContext context) {
    final effectiveBackgroundColor = backgroundColor ?? AppColors.lightGrey;
    final effectiveFallbackIconColor = fallbackIconColor ?? AppColors.grey;

    Widget buildFallback() {
      return Container(
        width: width,
        height: height,
        decoration: BoxDecoration(
          color: effectiveBackgroundColor,
          borderRadius: isCircular ? null : borderRadius,
          shape: isCircular ? BoxShape.circle : BoxShape.rectangle,
        ),
        child: Icon(
          fallbackIcon,
          color: effectiveFallbackIconColor,
          size: fallbackIconSize,
        ),
      );
    }

    // If imageUrl is null, empty, or invalid, show fallback
    if (!ImageUtils.isValidImageUrl(imageUrl)) {
      return buildFallback();
    }

    // Use CachedNetworkImage with proper CORS headers
     Widget imageWidget = CachedNetworkImage(
       imageUrl: imageUrl!,
       width: width,
       height: height,
       fit: fit,
       httpHeaders: const {
         'Access-Control-Allow-Origin': '*',
         'Access-Control-Allow-Methods': 'GET, POST, OPTIONS',
         'Access-Control-Allow-Headers': 'Origin, Content-Type, Accept, Authorization, X-Request-With',
       },
       placeholder: (context, url) => Container(
         width: width,
         height: height,
         decoration: BoxDecoration(
           color: effectiveBackgroundColor,
           borderRadius: isCircular ? null : borderRadius,
           shape: isCircular ? BoxShape.circle : BoxShape.rectangle,
         ),
         child: Center(
           child: CircularProgressIndicator(
             strokeWidth: 2,
             valueColor: AlwaysStoppedAnimation<Color>(
               AppColors.primaryBlue.withOpacity(0.6),
             ),
           ),
         ),
       ),
       errorWidget: (context, url, error) {
         debugPrint('Image loading error for URL: $url - Error: $error');
         return buildFallback();
       },
     );

    // Apply border radius if specified and not circular
    if (borderRadius != null && !isCircular) {
      imageWidget = ClipRRect(
        borderRadius: borderRadius!,
        child: imageWidget,
      );
    }

    // Apply circular clipping if specified
    if (isCircular) {
      imageWidget = ClipOval(
        child: imageWidget,
      );
    }

    return imageWidget;
  }
}

// Specialized widget for team logos
class TeamLogoWidget extends StatelessWidget {
  final String? logoUrl;
  final double size;
  final BorderRadius? borderRadius;

  const TeamLogoWidget({
    super.key,
    required this.logoUrl,
    this.size = 40,
    this.borderRadius,
  });

  @override
  Widget build(BuildContext context) {
    // Try Html approach first for better compatibility
    return _buildHtmlImage();
  }

  Widget _buildHtmlImage() {
    if (logoUrl == null || logoUrl!.isEmpty) {
      return _buildFallback();
    }

    return Container(
      width: size,
      height: size,
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: borderRadius ?? BorderRadius.circular(8),
      ),
      child: ClipRRect(
        borderRadius: borderRadius ?? BorderRadius.circular(8),
        child: Image.network(
          logoUrl!,
          width: size,
          height: size,
          fit: BoxFit.cover,
          loadingBuilder: (context, child, loadingProgress) {
            if (loadingProgress == null) return child;
            return Container(
              width: size,
              height: size,
              color: AppColors.surfaceBackground,
              child: Center(
                child: CircularProgressIndicator(
                  strokeWidth: 2,
                  value: loadingProgress.expectedTotalBytes != null
                      ? loadingProgress.cumulativeBytesLoaded /
                          loadingProgress.expectedTotalBytes!
                      : null,
                  valueColor: AlwaysStoppedAnimation<Color>(
                    AppColors.primaryBlue.withOpacity(0.6),
                  ),
                ),
              ),
            );
          },
          errorBuilder: (context, error, stackTrace) {
            debugPrint('Team logo loading error for URL: $logoUrl - Error: $error');
            return _buildFallback();
          },
        ),
      ),
    );
  }

  Widget _buildFallback() {
    return Container(
      width: size,
      height: size,
      decoration: BoxDecoration(
        color: AppColors.surfaceBackground,
        borderRadius: borderRadius ?? BorderRadius.circular(8),
      ),
      child: Center(
        child: Icon(
          Icons.sports_soccer,
          size: size * 0.6,
          color: AppColors.textSecondary,
        ),
      ),
    );
  }
}

// Specialized widget for player images
class PlayerImageWidget extends StatelessWidget {
  final String? imageUrl;
  final double size;
  final bool isCircular;

  const PlayerImageWidget({
    super.key,
    required this.imageUrl,
    this.size = 120,
    this.isCircular = true,
  });

  @override
  Widget build(BuildContext context) {
    return CachedImageWidget(
      imageUrl: imageUrl,
      width: size,
      height: size,
      isCircular: isCircular,
      fallbackIcon: Icons.person,
      fallbackIconSize: size * 0.5,
    );
  }
}

// Specialized widget for news images
class NewsImageWidget extends StatelessWidget {
  final String? imageUrl;
  final double? width;
  final double? height;
  final BorderRadius? borderRadius;

  const NewsImageWidget({
    super.key,
    required this.imageUrl,
    this.width,
    this.height,
    this.borderRadius,
  });

  @override
  Widget build(BuildContext context) {
    return CachedImageWidget(
      imageUrl: imageUrl,
      width: width,
      height: height,
      borderRadius: borderRadius ?? BorderRadius.circular(8),
      fallbackIcon: Icons.article,
      fallbackIconSize: (width != null && height != null) 
          ? (width! < height! ? width! : height!) * 0.4
          : 30,
    );
  }
}