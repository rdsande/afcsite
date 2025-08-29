import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:google_fonts/google_fonts.dart';

import 'constants/app_routes.dart';
import 'constants/app_colors.dart';
import 'providers/language_provider.dart';
import 'providers/auth_provider.dart';
import 'providers/theme_provider.dart';
import 'providers/exclusive_stories_provider.dart';

void main() {
  runApp(const ProviderScope(child: MyApp()));
}

class MyApp extends ConsumerWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final languageState = ref.watch(languageProviderProvider);
    final blueTheme = ref.watch(blueThemeProvider);
    
    return MaterialApp.router(
      title: 'Azam FC',
      debugShowCheckedModeBanner: false, // Ensures no debug banner is shown
      locale: languageState,
      routerConfig: AppRoutes.router,
      theme: ThemeData(
        primarySwatch: Colors.blue,
        primaryColor: BlueThemeColors.getPrimaryColor(blueTheme),
        scaffoldBackgroundColor: AppColors.backgroundColor,
        fontFamily: GoogleFonts.barlow().fontFamily,
        textTheme: TextTheme(
          // Headlines and titles use Barlow - BOLD and CAPITALIZED
          headlineLarge: GoogleFonts.barlow(
            fontSize: 32,
            fontWeight: FontWeight.w900,
            color: AppColors.textPrimary,
          ),
          headlineMedium: GoogleFonts.barlow(
            fontSize: 28,
            fontWeight: FontWeight.w900,
            color: AppColors.textPrimary,
          ),
          headlineSmall: GoogleFonts.barlow(
            fontSize: 24,
            fontWeight: FontWeight.w900,
            color: AppColors.textPrimary,
          ),
          titleLarge: GoogleFonts.barlow(
            fontSize: 22,
            fontWeight: FontWeight.w900,
            color: AppColors.textPrimary,
          ),
          titleMedium: GoogleFonts.barlow(
            fontSize: 18,
            fontWeight: FontWeight.w900,
            color: AppColors.textPrimary,
          ),
          titleSmall: GoogleFonts.barlow(
            fontSize: 16,
            fontWeight: FontWeight.w900,
            color: AppColors.textPrimary,
          ),
          // Body text and news items use Barlow
          bodyLarge: GoogleFonts.barlow(
            fontSize: 16,
            fontWeight: FontWeight.w400,
            color: AppColors.textPrimary,
          ),
          bodyMedium: GoogleFonts.barlow(
            fontSize: 14,
            fontWeight: FontWeight.w400,
            color: AppColors.textPrimary,
          ),
          bodySmall: GoogleFonts.barlow(
            fontSize: 12,
            fontWeight: FontWeight.w400,
            color: AppColors.textSecondary,
          ),
        ),
        appBarTheme: AppBarTheme(
          backgroundColor: AppColors.backgroundColor,
          elevation: 0,
          titleTextStyle: GoogleFonts.barlow(
            fontSize: 20,
            fontWeight: FontWeight.w700,
            color: AppColors.textPrimary,
          ),
        ),
        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: BlueThemeColors.getPrimaryColor(blueTheme),
            foregroundColor: AppColors.white,
            elevation: 8,
            shadowColor: BlueThemeColors.getShadowColor(blueTheme),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(16),
            ),
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
            textStyle: GoogleFonts.poppins(
              fontSize: 16,
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
        textButtonTheme: TextButtonThemeData(
          style: TextButton.styleFrom(
            foregroundColor: BlueThemeColors.getPrimaryColor(blueTheme),
            textStyle: GoogleFonts.poppins(
              fontSize: 16,
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
        inputDecorationTheme: InputDecorationTheme(
          filled: true,
          fillColor: AppColors.white,
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide(color: AppColors.borderColor),
          ),
          enabledBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide(color: AppColors.borderColor),
          ),
          focusedBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide(color: BlueThemeColors.getPrimaryColor(blueTheme), width: 2),
          ),
          errorBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide(color: AppColors.error),
          ),
          contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
          hintStyle: GoogleFonts.poppins(
            color: AppColors.textLight,
            fontSize: 14,
          ),
        ),
        cardTheme: CardThemeData(
           color: AppColors.white,
           elevation: 4,
           shadowColor: BlueThemeColors.getShadowColor(blueTheme),
           shape: RoundedRectangleBorder(
             borderRadius: BorderRadius.circular(16),
           ),
         ),
      ),
    );
  }
}
