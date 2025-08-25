import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../constants/app_routes.dart';
import '../../providers/auth_provider.dart';
import '../../widgets/azam_logo.dart';

class SplashScreen extends ConsumerStatefulWidget {
  const SplashScreen({super.key});

  @override
  ConsumerState<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends ConsumerState<SplashScreen> {
  @override
  void initState() {
    super.initState();
    _initializeApp();
  }

  Future<void> _initializeApp() async {
    // Check authentication status
    await ref.read(authProviderProvider.notifier).checkAuthStatus();
    
    // Wait for animation to complete
    await Future.delayed(const Duration(seconds: 3));
    
    if (mounted) {
      // Check if this is the first launch
      final prefs = await SharedPreferences.getInstance();
      final isFirstLaunch = prefs.getBool('isFirstLaunch') ?? true;
      
      if (isFirstLaunch) {
        context.go(AppRoutes.onboarding);
      } else {
        context.go(AppRoutes.main);
      }
    }
  }



  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF1976D2),
      body: Container(
        decoration: const BoxDecoration(
          image: DecorationImage(
            image: AssetImage('assets/images/cover1.jpg'),
            fit: BoxFit.cover,
          ),
        ),
        // Add overlay for better logo visibility
        child: Container(
          decoration: BoxDecoration(
            color: Colors.black.withOpacity(0.3),
          ),
          child: SafeArea(
            child: Column(
              children: [
                const SizedBox(height: 120), // Push logo towards top
                // Logo Container - Full width, centered, bigger logo
                Container(
                  width: double.infinity,
                  child: Center(
                    child: Container(
                      width: 200,
                      height: 200,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        color: Colors.white,
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.15),
                            blurRadius: 30,
                            offset: const Offset(0, 15),
                            spreadRadius: 5,
                          ),
                          BoxShadow(
                            color: Colors.black.withOpacity(0.1),
                            blurRadius: 60,
                            offset: const Offset(0, 30),
                            spreadRadius: 10,
                          ),
                        ],
                      ),
                      child: const Padding(
                        padding: EdgeInsets.all(25),
                        child: AzamLogo(size: 150),
                      ),
                    ),
                  ),
                )
                  .animate()
                  .slideY(
                    begin: -0.5,
                    end: 0,
                    duration: const Duration(milliseconds: 1200),
                    curve: Curves.easeOutBack,
                  )
                  .fadeIn(
                    duration: const Duration(milliseconds: 800),
                  )
                  .scale(
                    begin: const Offset(0.8, 0.8),
                    end: const Offset(1.0, 1.0),
                    duration: const Duration(milliseconds: 1000),
                    curve: Curves.easeOutBack,
                  ),
                const Spacer(), // Fill remaining space
                // Animated cursive text at bottom
                Padding(
                  padding: const EdgeInsets.only(bottom: 60),
                  child: Column(
                    children: [
                      Text(
                        'timu bora',
                        style: GoogleFonts.dancingScript(
                          fontSize: 32,
                          fontWeight: FontWeight.w600,
                          color: Colors.white,
                          shadows: [
                            Shadow(
                              color: Colors.black.withOpacity(0.5),
                              offset: const Offset(2, 2),
                              blurRadius: 4,
                            ),
                          ],
                        ),
                      )
                        .animate(delay: const Duration(milliseconds: 1500))
                        .fadeIn(
                          duration: const Duration(milliseconds: 1000),
                        )
                        .slideY(
                          begin: 0.3,
                          end: 0,
                          duration: const Duration(milliseconds: 800),
                          curve: Curves.easeOutBack,
                        ),
                      const SizedBox(height: 8),
                      Text(
                        'bidhaa bora',
                        style: GoogleFonts.dancingScript(
                          fontSize: 32,
                          fontWeight: FontWeight.w600,
                          color: Colors.white,
                          shadows: [
                            Shadow(
                              color: Colors.black.withOpacity(0.5),
                              offset: const Offset(2, 2),
                              blurRadius: 4,
                            ),
                          ],
                        ),
                      )
                        .animate(delay: const Duration(milliseconds: 2000))
                        .fadeIn(
                          duration: const Duration(milliseconds: 1000),
                        )
                        .slideY(
                          begin: 0.3,
                          end: 0,
                          duration: const Duration(milliseconds: 800),
                          curve: Curves.easeOutBack,
                        ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
