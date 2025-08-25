class Fan {
  final int id;
  final String firstName;
  final String lastName;
  final String email;
  final String? phone;
  final String? region;
  final String? district;
  final String? profileImage;
  final int points;
  final String? level;
  final DateTime? dateOfBirth;
  final String? gender;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Fan({
    required this.id,
    required this.firstName,
    required this.lastName,
    required this.email,
    this.phone,
    this.region,
    this.district,
    this.profileImage,
    this.points = 0,
    this.level,
    this.dateOfBirth,
    this.gender,
    this.createdAt,
    this.updatedAt,
  });

  String get fullName => '$firstName $lastName';
  bool get isEmailVerified => true; // Assuming email is verified for now
  int? get age => dateOfBirth != null ? DateTime.now().difference(dateOfBirth!).inDays ~/ 365 : null;
  String? get location {
    if (region != null && district != null) {
      return '$region, $district';
    } else if (region != null) {
      return region!;
    } else if (district != null) {
      return district!;
    }
    return null;
  }

  factory Fan.fromJson(Map<String, dynamic> json) {
    return Fan(
      id: json['id'] ?? 0,
      firstName: json['first_name'] ?? '',
      lastName: json['last_name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'],
      region: json['region'],
      district: json['district'],
      profileImage: json['profile_image'],
      points: json['points'] ?? 0,
      level: json['level'],
      dateOfBirth: json['date_of_birth'] != null 
          ? DateTime.parse(json['date_of_birth']) 
          : null,
      gender: json['gender'],
      createdAt: json['created_at'] != null 
          ? DateTime.parse(json['created_at']) 
          : null,
      updatedAt: json['updated_at'] != null 
          ? DateTime.parse(json['updated_at']) 
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'first_name': firstName,
      'last_name': lastName,
      'email': email,
      'phone': phone,
      'region': region,
      'district': district,
      'profile_image': profileImage,
      'points': points,
      'level': level,
      'date_of_birth': dateOfBirth?.toIso8601String(),
      'gender': gender,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }
}

class FansResponse {
  final List<Fan> fans;
  final FansPagination pagination;

  FansResponse({
    required this.fans,
    required this.pagination,
  });

  factory FansResponse.fromJson(Map<String, dynamic> json) {
    return FansResponse(
      fans: (json['data'] as List)
          .map((fanJson) => Fan.fromJson(fanJson))
          .toList(),
      pagination: FansPagination.fromJson(json['pagination']),
    );
  }
}

class FansPagination {
  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;
  final int? from;
  final int? to;

  FansPagination({
    required this.currentPage,
    required this.lastPage,
    required this.perPage,
    required this.total,
    this.from,
    this.to,
  });

  factory FansPagination.fromJson(Map<String, dynamic> json) {
    return FansPagination(
      currentPage: json['current_page'],
      lastPage: json['last_page'],
      perPage: json['per_page'],
      total: json['total'],
      from: json['from'],
      to: json['to'],
    );
  }

  bool get hasNextPage => currentPage < lastPage;
  bool get hasPreviousPage => currentPage > 1;
}
