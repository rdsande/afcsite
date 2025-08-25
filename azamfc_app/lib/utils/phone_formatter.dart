class PhoneFormatter {
  /// Formats a Tanzanian phone number to the standard format expected by the backend
  /// Handles inputs like:
  /// - +255712345678 -> +255712345678
  /// - 255712345678 -> +255712345678
  /// - 0712345678 -> +255712345678
  /// - 712345678 -> +255712345678
  static String formatTanzanianPhone(String phone) {
    // Remove all spaces and special characters except +
    String cleaned = phone.replaceAll(RegExp(r'[\s\-\(\)]'), '');
    
    // Handle different formats
    if (cleaned.startsWith('+255')) {
      // +255712345678 -> +255712345678 (already correct)
      return cleaned;
    } else if (cleaned.startsWith('255')) {
      // 255712345678 -> +255712345678
      return '+$cleaned';
    } else if (cleaned.startsWith('0')) {
      // 0712345678 -> +255712345678
      String withoutZero = cleaned.substring(1);
      return '+255$withoutZero';
    } else if (cleaned.length == 9 && cleaned.startsWith('7')) {
      // 712345678 -> +255712345678
      return '+255$cleaned';
    }
    
    // Return as-is if format is not recognized
    return cleaned;
  }
  
  /// Validates if a phone number is a valid Tanzanian mobile number
  /// Valid formats: +25571xxxxxxx, +25572xxxxxxx, +25573xxxxxxx, +25574xxxxxxx, +25575xxxxxxx, +25576xxxxxxx, +25577xxxxxxx, +25578xxxxxxx, +25579xxxxxxx
  static bool isValidTanzanianPhone(String phone) {
    String formatted = formatTanzanianPhone(phone);
    
    // Check if it matches Tanzanian mobile number pattern
    RegExp tanzanianMobilePattern = RegExp(r'^\+2557[1-9]\d{7}$');
    return tanzanianMobilePattern.hasMatch(formatted);
  }
  
  /// Formats phone number for display with +255 prefix
  /// +255712345678 -> +255 712 345 678
  static String formatForDisplay(String phone) {
    String formatted = formatTanzanianPhone(phone);
    if (formatted.startsWith('+255') && formatted.length == 13) {
      String withoutCountryCode = formatted.substring(4);
      return '+255 ${withoutCountryCode.substring(0, 3)} ${withoutCountryCode.substring(3, 6)} ${withoutCountryCode.substring(6)}';
    }
    return phone;
  }
}