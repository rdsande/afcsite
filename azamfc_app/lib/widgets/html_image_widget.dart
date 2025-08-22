import 'package:flutter/material.dart';
import 'package:flutter_html/flutter_html.dart';

import '../constants/app_colors.dart';

class HtmlImageWidget extends StatelessWidget {
  final String? imageUrl;
  final double width;
  final double height;
  final BoxFit fit;
  final bool isCircular;
  final BorderRadius? borderRadius;
  final IconData fallbackIcon;
  final double fallbackIconSize;
  final Color? backgroundColor;

  const HtmlImageWidget({
    super.key,
    required this.imageUrl,
    this.width = 100,
    this.height = 100,
    this.fit = BoxFit.cover,
    this.isCircular = false,
    this.borderRadius,
    this.fallbackIcon = Icons.image,
    this.fallbackIconSize = 40,
    this.backgroundColor,
  });

  @override
  Widget build(BuildContext context) {
    if (imageUrl == null || imageUrl!.isEmpty) {
      return _buildFallback();
    }

    final effectiveBackgroundColor = backgroundColor ?? AppColors.surfaceBackground;

    return Container(
      width: width,
      height: height,
      decoration: BoxDecoration(
        color: effectiveBackgroundColor,
        borderRadius: isCircular ? null : borderRadius,
        shape: isCircular ? BoxShape.circle : BoxShape.rectangle,
      ),
      child: ClipRRect(
        borderRadius: isCircular 
            ? BorderRadius.circular(width / 2) 
            : (borderRadius ?? BorderRadius.zero),
        child: Html(
          data: '<img src="${imageUrl!}" style="width: ${width}px; height: ${height}px; object-fit: ${_getObjectFit()};">',
          style: {
            "body": Style(
              margin: Margins.zero,
              padding: HtmlPaddings.zero,
            ),
            "img": Style(
              width: Width(width),
              height: Height(height),
              margin: Margins.zero,
              padding: HtmlPaddings.zero,
            ),
          },
        ),
      ),
    );
  }

  String _getObjectFit() {
    switch (fit) {
      case BoxFit.cover:
        return 'cover';
      case BoxFit.contain:
        return 'contain';
      case BoxFit.fill:
        return 'fill';
      case BoxFit.fitWidth:
        return 'cover';
      case BoxFit.fitHeight:
        return 'cover';
      case BoxFit.none:
        return 'none';
      case BoxFit.scaleDown:
        return 'scale-down';
    }
  }

  Widget _buildFallback() {
    final effectiveBackgroundColor = backgroundColor ?? AppColors.surfaceBackground;
    
    return Container(
      width: width,
      height: height,
      decoration: BoxDecoration(
        color: effectiveBackgroundColor,
        borderRadius: isCircular ? null : borderRadius,
        shape: isCircular ? BoxShape.circle : BoxShape.rectangle,
      ),
      child: Center(
        child: Icon(
          fallbackIcon,
          size: fallbackIconSize,
          color: AppColors.textSecondary,
        ),
      ),
    );
  }
}

// Specialized widget for team logos using Html approach
class HtmlTeamLogoWidget extends StatelessWidget {
  final String? logoUrl;
  final double size;
  final BorderRadius? borderRadius;

  const HtmlTeamLogoWidget({
    super.key,
    required this.logoUrl,
    this.size = 40,
    this.borderRadius,
  });

  @override
  Widget build(BuildContext context) {
    return HtmlImageWidget(
      imageUrl: logoUrl,
      width: size,
      height: size,
      borderRadius: borderRadius ?? BorderRadius.circular(8),
      fallbackIcon: Icons.sports_soccer,
      fallbackIconSize: size * 0.6,
    );
  }
}