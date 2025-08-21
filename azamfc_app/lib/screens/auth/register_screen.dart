import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:intl/intl.dart';

import '../../constants/app_colors.dart';
import '../../providers/auth_provider.dart';
import '../../providers/language_provider.dart';
import '../../services/api_service.dart';
import '../../widgets/azam_logo.dart';
import '../../widgets/custom_dropdown.dart';
import '../../widgets/custom_text_field.dart';
import '../../utils/phone_formatter.dart';

class RegisterScreen extends ConsumerStatefulWidget {
  const RegisterScreen({super.key});

  @override
  ConsumerState<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends ConsumerState<RegisterScreen> {
  final _formKey = GlobalKey<FormState>();
  final _nameController = TextEditingController();
  final _passwordController = TextEditingController();
  final _dateOfBirthController = TextEditingController();
  final _phoneController = TextEditingController();
  final _regionController = TextEditingController();
  final _districtController = TextEditingController();
  
  bool _obscurePassword = true;
  
  String _selectedGender = 'male';
  DateTime? _selectedDate;



  @override
  void dispose() {
    _nameController.dispose();
    _passwordController.dispose();
    _dateOfBirthController.dispose();
    _phoneController.dispose();
    _regionController.dispose();
    _districtController.dispose();
    super.dispose();
  }

  void _selectDate() async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: DateTime.now().subtract(const Duration(days: 6570)), // 18 years ago
      firstDate: DateTime.now().subtract(const Duration(days: 36500)), // 100 years ago
      lastDate: DateTime.now().subtract(const Duration(days: 6570)), // 18 years ago
    );
    
    if (picked != null) {
      setState(() {
        _selectedDate = picked;
        _dateOfBirthController.text = DateFormat('dd/MM/yyyy').format(picked);
      });
    }
  }



  void _submitForm() {
    if (_formKey.currentState!.validate()) {
      // Handle form submission
      // Split name into first and last name
      final nameParts = _nameController.text.trim().split(' ');
      final firstName = nameParts.first;
      final lastName = nameParts.length > 1 ? nameParts.sublist(1).join(' ') : '';
      
      // Add +255 prefix since the UI shows it but user enters without it
      final phoneWithPrefix = '+255${_phoneController.text.trim()}';
      final formattedPhone = PhoneFormatter.formatTanzanianPhone(phoneWithPrefix);
      
      ref.read(authProviderProvider.notifier).register(
        firstName: firstName,
        lastName: lastName,
        password: _passwordController.text,
        phone: formattedPhone,
        dateOfBirth: _selectedDate!,
        gender: _selectedGender,
        region: _regionController.text.trim(),
        district: _districtController.text.trim(),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final isEnglish = ref.watch(languageProviderProvider).languageCode == 'en';
    final authState = ref.watch(authProviderProvider);
    
    // Listen to auth state changes
    ref.listen<AuthState>(authProviderProvider, (previous, next) {
      if (next.error != null) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(next.error!),
            backgroundColor: AppColors.error,
            duration: const Duration(seconds: 4),
          ),
        );
      } else if (next.isAuthenticated) {
        // Navigate to main screen on successful registration
        context.go('/main');
      }
    });
    
    return Scaffold(
      backgroundColor: AppColors.backgroundColor,
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24),
          child: Form(
            key: _formKey,
            child: Column(
              children: [
                // Skip button
                Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    TextButton(
                      onPressed: () {
                        context.go('/main');
                      },
                      child: Text(
                        isEnglish ? 'Skip' : 'Ruka',
                        style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          color: AppColors.primaryBlue,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                  ],
                ),
                // Logo and Title
                const SizedBox(height: 20),
                const AzamLogo(size: 80),
                const SizedBox(height: 32),
                
                Text(
                  isEnglish ? 'JOIN AZAMFC APP' : 'JIUNGE AZAMFC APP',
                  style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                    color: AppColors.primaryBlue,
                    fontWeight: FontWeight.w900,
                    letterSpacing: 1.0,
                  ),
                  textAlign: TextAlign.center,
                ),
                
                const SizedBox(height: 48),
                
                // Error Message
                if (authState.error != null) ...[
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(16),
                    margin: const EdgeInsets.only(bottom: 24),
                    decoration: BoxDecoration(
                      color: AppColors.error.withOpacity(0.1),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(color: AppColors.error.withOpacity(0.3)),
                    ),
                    child: Text(
                      authState.error!,
                      style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                        color: AppColors.error,
                        fontWeight: FontWeight.w500,
                      ),
                      textAlign: TextAlign.center,
                    ),
                  ),
                ],
                
                // Form Fields
                _buildFormFields(isEnglish),
                
                const SizedBox(height: 32),
                
                // Terms and Conditions
                _buildTermsAndConditions(isEnglish),
                
                const SizedBox(height: 32),
                
                // Submit Button
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    onPressed: authState.isLoading ? null : _submitForm,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.primaryBlue,
                      padding: const EdgeInsets.symmetric(vertical: 20),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    child: authState.isLoading
                         ? const SizedBox(
                             height: 20,
                             width: 20,
                             child: CircularProgressIndicator(
                               strokeWidth: 2,
                               valueColor: AlwaysStoppedAnimation<Color>(Colors.white),
                             ),
                           )
                        : Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Text(
                                isEnglish ? 'CONTINUE' : 'ENDELEA',
                                style: Theme.of(context).textTheme.titleLarge?.copyWith(
                                  color: AppColors.white,
                                  fontWeight: FontWeight.w700,
                                  letterSpacing: 0.5,
                                ),
                              ),
                              const SizedBox(width: 8),
                              const Icon(
                                Icons.arrow_forward,
                                color: AppColors.white,
                                size: 20,
                              ),
                            ],
                          ),
                  ),
                ),
                
                const SizedBox(height: 24),
                
                // Login Link
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(
                      isEnglish ? 'Already have an account? ' : 'Una akaunti? ',
                      style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                        color: AppColors.textSecondary,
                      ),
                    ),
                    TextButton(
                      onPressed: () {
                        context.go('/login');
                      },
                      child: Text(
                        isEnglish ? 'Login' : 'Ingia',
                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                          color: AppColors.primaryBlue,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildFormFields(bool isEnglish) {
    return Column(
      children: [
        // Name Field
        CustomTextField(
          controller: _nameController,
          label: isEnglish ? 'Your Name' : 'Majina yako:',
          icon: Icons.person_outline,
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return isEnglish ? 'Please enter your name' : 'Tafadhali weka majina yako';
            }
            if (value.trim().split(' ').length < 2) {
              return isEnglish ? 'Please enter your full name' : 'Tafadhali weka majina yako kamili';
            }
            return null;
          },
        ),
        
        const SizedBox(height: 20),
        

        
        // Password Field
        CustomTextField(
          controller: _passwordController,
          label: isEnglish ? 'Password' : 'Nywila',
          icon: Icons.lock_outlined,
          obscureText: _obscurePassword,
          suffixIcon: IconButton(
            icon: Icon(
              _obscurePassword ? Icons.visibility_outlined : Icons.visibility_off_outlined,
            ),
            onPressed: () {
              setState(() {
                _obscurePassword = !_obscurePassword;
              });
            },
          ),
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return isEnglish ? 'Please enter a password' : 'Tafadhali weka nywila';
            }
            if (value.length < 6) {
              return isEnglish ? 'Password must be at least 6 characters' : 'Nywila lazima iwe angalau herufi 6';
            }
            return null;
          },
        ),
        
        const SizedBox(height: 20),
        
        // Date of Birth Field
        CustomTextField(
          controller: _dateOfBirthController,
          label: isEnglish ? 'Date of Birth' : 'Tarehe ya kuzaliwa',
          icon: Icons.calendar_today,
          readOnly: true,
          onTap: _selectDate,
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return isEnglish ? 'Please select your date of birth' : 'Tafadhali chagua tarehe ya kuzaliwa';
            }
            return null;
          },
        ),
        
        const SizedBox(height: 20),
        
        // Phone Number Field
        CustomTextField(
          controller: _phoneController,
          label: isEnglish ? 'Phone Number' : 'Namba ya simu:',
          icon: Icons.phone,
          keyboardType: TextInputType.phone,
          prefix: Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 24,
                height: 16,
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(2),
                  color: AppColors.primaryBlue,
                ),
                child: const Center(
                  child: Text(
                    '🇹🇿',
                    style: TextStyle(fontSize: 10),
                  ),
                ),
              ),
              const SizedBox(width: 8),
              Text(
                '+255',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: AppColors.textSecondary,
                  fontWeight: FontWeight.w600,
                ),
              ),
              const SizedBox(width: 8),
            ],
          ),
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return isEnglish ? 'Please enter your phone number' : 'Tafadhali weka namba ya simu';
            }
            // Since UI shows +255 prefix, user enters only the mobile part (e.g., 712345678)
            // We need to add 0 prefix to make it 0712345678 for validation
            String phoneForValidation = '0${value.trim()}';
            if (!PhoneFormatter.isValidTanzanianPhone(phoneForValidation)) {
              return isEnglish ? 'Please enter a valid Tanzanian phone number' : 'Tafadhali weka namba sahihi ya simu ya Tanzania';
            }
            return null;
          },
        ),
        
        const SizedBox(height: 20),
        
        // Gender Selection
        Text(
          isEnglish ? 'Gender:' : 'Jinsia:',
          style: Theme.of(context).textTheme.titleMedium?.copyWith(
            color: AppColors.textPrimary,
            fontWeight: FontWeight.w600,
          ),
        ),
        const SizedBox(height: 12),
        Row(
          children: [
            Expanded(
              child: _buildGenderButton(
                'male',
                isEnglish ? 'Male' : 'Me',
                _selectedGender == 'male',
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: _buildGenderButton(
                'female',
                isEnglish ? 'Female' : 'Ke',
                _selectedGender == 'female',
              ),
            ),
          ],
        ),
        
        const SizedBox(height: 20),
        
        // Region Field
        CustomTextField(
          controller: _regionController,
          label: isEnglish ? 'Region' : 'Mkoa',
          icon: Icons.location_on_outlined,
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return isEnglish ? 'Please enter your region' : 'Tafadhali weka mkoa wako';
            }
            return null;
          },
        ),
        
        const SizedBox(height: 20),
        
        // District Field
        CustomTextField(
          controller: _districtController,
          label: isEnglish ? 'District' : 'Wilaya',
          icon: Icons.location_city_outlined,
          validator: (value) {
            if (value == null || value.trim().isEmpty) {
              return isEnglish ? 'Please enter your district' : 'Tafadhali weka wilaya yako';
            }
            return null;
          },
        ),
        
        const SizedBox(height: 20),
        

      ],
    );
  }

  Widget _buildGenderButton(String gender, String label, bool isSelected) {
    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedGender = gender;
        });
      },
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 16),
        decoration: BoxDecoration(
          color: isSelected ? AppColors.primaryBlue : AppColors.surfaceBackground,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: isSelected ? AppColors.primaryBlue : AppColors.borderColor,
            width: 2,
          ),
        ),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 20,
              height: 20,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: isSelected ? AppColors.white : AppColors.primaryBlue,
                border: Border.all(
                  color: isSelected ? AppColors.white : AppColors.primaryBlue,
                  width: 2,
                ),
              ),
              child: isSelected
                  ? const Icon(
                      Icons.check,
                      size: 12,
                      color: AppColors.primaryBlue,
                    )
                  : null,
            ),
            const SizedBox(width: 12),
            Text(
              label,
              style: Theme.of(context).textTheme.titleMedium?.copyWith(
                color: isSelected ? AppColors.white : AppColors.textPrimary,
                fontWeight: FontWeight.w600,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildTermsAndConditions(bool isEnglish) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: AppColors.surfaceBackground,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(
          color: AppColors.borderColorLight,
          width: 1,
        ),
      ),
      child: Column(
        children: [
          Text(
            isEnglish 
                ? 'By choosing Continue, you confirm that you agree to the Terms and Conditions. View terms and conditions.'
                : 'Kwa kuchagua Endelea, unathibitisha kuwa unakubaliana na Vigezo na Masharti. Tazama vigezo na Masharti.',
            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
              color: AppColors.textSecondary,
              height: 1.5,
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 12),
          TextButton(
            onPressed: () {
              // Navigate to terms and conditions
            },
            child: Text(
              isEnglish ? 'View terms and conditions' : 'Tazama vigezo na Masharti',
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                color: AppColors.primaryBlue,
                fontWeight: FontWeight.w600,
                decoration: TextDecoration.underline,
              ),
            ),
          ),
        ],
      ),
    );
  }
}
