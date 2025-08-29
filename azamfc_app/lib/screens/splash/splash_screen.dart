import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:video_player/video_player.dart';
import '../../constants/app_routes.dart';
import '../../providers/auth_provider.dart';
import '../../providers/language_provider.dart';
import '../../widgets/azam_logo.dart';

class SplashScreen extends ConsumerStatefulWidget {
  const SplashScreen({super.key});

  @override
  ConsumerState<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends ConsumerState<SplashScreen> {
  late VideoPlayerController _videoController;
  bool _showLanguageSelection = false;
  String _selectedLanguage = 'sw'; // Default to Swahili
  bool _videoInitialized = false;

  @override
  void initState() {
    super.initState();
    _initializeVideo();
  }

  void _initializeVideo() {
    _videoController = VideoPlayerController.asset('assets/images/splashafc.mp4')
      ..initialize().then((_) {
        setState(() {
          _videoInitialized = true;
        });
        _videoController.play();
        
        // Auto-proceed after 5 seconds if no user interaction
        Future.delayed(const Duration(seconds: 5), () {
          if (mounted && !_showLanguageSelection) {
            setState(() {
              _showLanguageSelection = true;
            });
          }
        });
      });
      
    // Set video to autoplay and loop
    _videoController.setLooping(true);
  }

  void _continueToLanguageSelection() {
    setState(() {
      _showLanguageSelection = true;
    });
  }

  Future<void> _initializeApp() async {
    // Check authentication status
    await ref.read(authProviderProvider.notifier).checkAuthStatus();
    
    if (mounted) {
      // Save language preference
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('language', _selectedLanguage);
      
      // Set language in provider
      ref.read(languageProviderProvider.notifier).setLanguage(_selectedLanguage);
      
      // Check if this is the first launch
      final isFirstLaunch = prefs.getBool('isFirstLaunch') ?? true;
      
      if (isFirstLaunch) {
        context.go(AppRoutes.onboarding);
      } else {
        context.go(AppRoutes.main);
      }
    }
  }

  @override
  void dispose() {
    _videoController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: _showLanguageSelection ? _buildLanguageSelection() : _buildVideoPlayer(),
    );
  }
  
  Widget _buildVideoPlayer() {
    if (_videoInitialized) {
      return Stack(
        children: [
          // Full screen video player
          SizedBox.expand(
            child: FittedBox(
              fit: BoxFit.cover,
              child: SizedBox(
                width: _videoController.value.size.width,
                height: _videoController.value.size.height,
                child: VideoPlayer(_videoController),
              ),
            ),
          ),
          Positioned(
            top: 20,
            right: 20,
            child: ElevatedButton(
              onPressed: _continueToLanguageSelection,
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.white.withOpacity(0.8),
                foregroundColor: Colors.black,
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(20),
                ),
              ),
              child: const Text('Continue'),
            ).animate().fadeIn(
              duration: const Duration(milliseconds: 800),
              delay: const Duration(milliseconds: 500),
            ),
          ),
        ],
      );
    } else {
      return const Center(
        child: CircularProgressIndicator(
          color: Colors.white,
        ),
      );
    }
  }
  
  Widget _buildLanguageSelection() {
    return Container(
      decoration: const BoxDecoration(
        color: Color(0xFF1976D2),
      ),
      child: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              // Logo
              const AzamLogo(size: 120)
                .animate()
                .fadeIn(
                  duration: const Duration(milliseconds: 800),
                ),
              
              const SizedBox(height: 60),
              
              // Language selection title
              Text(
                'Chagua Lugha / Select Language',
                style: GoogleFonts.bigShouldersDisplay(
                  fontSize: 24,
                  color: Colors.white,
                  fontWeight: FontWeight.bold,
                ),
                textAlign: TextAlign.center,
              ).animate().fadeIn(
                duration: const Duration(milliseconds: 600),
                delay: const Duration(milliseconds: 200),
              ),
              
              const SizedBox(height: 40),
              
              // Language buttons
              Row(
                children: [
                  Expanded(
                    child: _buildLanguageButton(
                      'sw',
                      'SWAHILI',
                      _selectedLanguage == 'sw',
                    ),
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: _buildLanguageButton(
                      'en',
                      'ENGLISH',
                      _selectedLanguage == 'en',
                    ),
                  ),
                ],
              ).animate().fadeIn(
                duration: const Duration(milliseconds: 600),
                delay: const Duration(milliseconds: 400),
              ),
              
              const SizedBox(height: 40),
              
              // Continue button
              ElevatedButton(
                onPressed: _initializeApp,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.white,
                  foregroundColor: const Color(0xFF1976D2),
                  padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 16),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(30),
                  ),
                ),
                child: Text(
                  _selectedLanguage == 'sw' ? 'Endelea' : 'Continue',
                  style: GoogleFonts.bigShouldersDisplay(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                    color: const Color(0xFF1976D2),
                  ),
                ),
              ).animate().fadeIn(
                duration: const Duration(milliseconds: 600),
                delay: const Duration(milliseconds: 600),
              ),
            ],
          ),
        ),
      ),
    );
  }
  
  Widget _buildLanguageButton(String code, String label, bool isSelected) {
    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedLanguage = code;
        });
      },
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 16),
        decoration: BoxDecoration(
          color: isSelected ? Colors.white : Colors.white.withOpacity(0.2),
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: Colors.white,
            width: 2,
          ),
        ),
        child: Center(
          child: Text(
            label,
            style: TextStyle(
              color: isSelected ? const Color(0xFF1976D2) : Colors.white,
              fontWeight: FontWeight.bold,
              fontSize: 16,
            ),
          ),
        ),
      ),
    );
  }
}
