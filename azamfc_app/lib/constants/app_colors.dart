import 'package:flutter/material.dart';

class AppColors {
  // Primary Colors
  static const Color primaryBlue = Color(0xFF1976D2);
  static const Color primaryBlueDark = Color(0xFF1565C0);
  static const Color primaryBlueLight = Color(0xFF42A5F5);
  
  // Secondary Colors
  static const Color secondaryGold = Color(0xFFFFD700);
  static const Color secondaryRed = Color(0xFFD32F2F);
  static const Color secondaryGreen = Color(0xFF388E3C);
  
  // Neutral Colors
  static const Color white = Color(0xFFFFFFFF);
  static const Color black = Color(0xFF000000);
  static const Color grey = Color(0xFF9E9E9E);
  static const Color lightGrey = Color(0xFFF5F5F5);
  static const Color darkGrey = Color(0xFF424242);
  
  // Background Colors
  static const Color backgroundColor = Color(0xFFFAFAFA);
  static const Color cardBackground = Color(0xFFFFFFFF);
  static const Color surfaceBackground = Color(0xFFF8F9FA);
  
  // Text Colors
  static const Color textPrimary = Color(0xFF212121);
  static const Color textSecondary = Color(0xFF757575);
  static const Color textLight = Color(0xFFBDBDBD);
  static const Color textWhite = Color(0xFFFFFFFF);
  
  // Status Colors
  static const Color success = Color(0xFF4CAF50);
  static const Color warning = Color(0xFFFF9800);
  static const Color error = Color(0xFFF44336);
  static const Color info = Color(0xFF2196F3);
  
  // Gradient Colors
  static const LinearGradient primaryGradient = LinearGradient(
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
    colors: [primaryBlue, primaryBlueDark],
  );
  
  static const LinearGradient secondaryGradient = LinearGradient(
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
    colors: [secondaryGold, Color(0xFFFFC107)],
  );
  
  // Shadow Colors
  static const Color shadowColor = Color(0x1A000000);
  static const Color shadowColorLight = Color(0x0A000000);
  
  // Border Colors
  static const Color borderColor = Color(0xFFE0E0E0);
  static const Color borderColorLight = Color(0xFFF0F0F0);
  
  // Overlay Colors
  static const Color overlayColor = Color(0x80000000);
  static const Color overlayColorLight = Color(0x40000000);
}
