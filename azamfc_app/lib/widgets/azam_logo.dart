import 'package:flutter/material.dart';

import '../constants/app_colors.dart';

class AzamLogo extends StatelessWidget {
  final double size;
  final bool showText;
  final Color? backgroundColor;
  final Color? logoColor;

  const AzamLogo({
    super.key,
    this.size = 80,
    this.showText = false,
    this.backgroundColor,
    this.logoColor,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisSize: MainAxisSize.min,
      children: [
        // Logo Circle
        Container(
          width: size,
          height: size,
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            color: backgroundColor ?? AppColors.white,
            boxShadow: [
              BoxShadow(
                color: AppColors.shadowColor,
                blurRadius: 20,
                offset: const Offset(0, 10),
              ),
            ],
          ),
          child: Center(
            child: _buildSimpleLogo(),
          ),
        ),
        
        // Text below logo (if enabled)
        if (showText) ...[
          const SizedBox(height: 16),
          _buildLogoText(context),
        ],
      ],
    );
  }

  Widget _buildSimpleLogo() {
    // Simple logo using basic shapes instead of CustomPaint
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        // Football icon
        Container(
          width: size * 0.3,
          height: size * 0.3,
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            color: AppColors.black,
          ),
          child: Center(
            child: Container(
              width: size * 0.15,
              height: size * 0.15,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: AppColors.white,
              ),
            ),
          ),
        ),
        const SizedBox(height: 8),
        // AZAM text
        Text(
          'AZAM',
          style: TextStyle(
            color: AppColors.primaryBlue,
            fontSize: size * 0.2,
            fontWeight: FontWeight.w700,
            letterSpacing: 1.0,
          ),
        ),
        Text(
          '2004',
          style: TextStyle(
            color: AppColors.secondaryRed,
            fontSize: size * 0.15,
            fontWeight: FontWeight.w600,
          ),
        ),
      ],
    );
  }

  Widget _buildLogoText(BuildContext context) {
    return Column(
      children: [
        Text(
          'AZAM FOOTBALL CLUB',
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            color: AppColors.white,
            fontWeight: FontWeight.w700,
            letterSpacing: 0.5,
          ),
        ),
        const SizedBox(height: 4),
        Text(
          'DAR ES SALAAM',
          style: Theme.of(context).textTheme.bodyMedium?.copyWith(
            color: AppColors.white.withOpacity(0.8),
            fontWeight: FontWeight.w500,
            letterSpacing: 0.3,
          ),
        ),
      ],
    );
  }
}
