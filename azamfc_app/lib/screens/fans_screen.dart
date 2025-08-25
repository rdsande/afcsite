import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../models/fan.dart';
import '../providers/fans_provider.dart';

class FansScreen extends ConsumerStatefulWidget {
  const FansScreen({Key? key}) : super(key: key);

  @override
  ConsumerState<FansScreen> createState() => _FansScreenState();
}

class _FansScreenState extends ConsumerState<FansScreen> {
  final ScrollController _scrollController = ScrollController();
  final TextEditingController _searchController = TextEditingController();
  String _selectedSort = 'points';
  String _selectedOrder = 'desc';

  @override
  void initState() {
    super.initState();
    _scrollController.addListener(_onScroll);
    WidgetsBinding.instance.addPostFrameCallback((_) {
      ref.read(fansProvider.notifier).loadFans();
    });
  }

  @override
  void dispose() {
    _scrollController.dispose();
    _searchController.dispose();
    super.dispose();
  }

  void _onScroll() {
    if (_scrollController.position.pixels >=
        _scrollController.position.maxScrollExtent - 200) {
      ref.read(fansProvider.notifier).loadMoreFans();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Fans'),
        backgroundColor: Colors.blue[800],
        foregroundColor: Colors.white,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.sort),
            onPressed: _showSortDialog,
          ),
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: () {
              ref.read(fansProvider.notifier).refreshFans();
            },
          ),
        ],
      ),
      body: Column(
        children: [
          _buildSearchBar(),
          Expanded(
            child: Consumer(
              builder: (context, ref, child) {
                final fansState = ref.watch(fansProvider);
                if (fansState.isLoading && fansState.fans.isEmpty) {
                  return const Center(
                    child: CircularProgressIndicator(),
                  );
                }

                if (fansState.error != null && fansState.fans.isEmpty) {
                  return _buildErrorState(fansState.error!);
                }

                if (fansState.fans.isEmpty) {
                  return _buildEmptyState();
                }

                return RefreshIndicator(
                  onRefresh: () => ref.read(fansProvider.notifier).refreshFans(),
                  child: ListView.builder(
                    controller: _scrollController,
                    padding: const EdgeInsets.all(16),
                    itemCount: fansState.fans.length + 
                        (fansState.hasNextPage ? 1 : 0),
                    itemBuilder: (context, index) {
                      if (index >= fansState.fans.length) {
                        return fansState.isLoadingMore
                            ? const Padding(
                                padding: EdgeInsets.all(16),
                                child: Center(
                                  child: CircularProgressIndicator(),
                                ),
                              )
                            : const SizedBox.shrink();
                      }

                      final fan = fansState.fans[index];
                      return _buildFanCard(fan, index);
                    },
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSearchBar() {
    return Container(
      padding: const EdgeInsets.all(16),
      color: Colors.grey[100],
      child: TextField(
        controller: _searchController,
        decoration: InputDecoration(
          hintText: 'Search fans by name or location...',
          prefixIcon: const Icon(Icons.search),
          suffixIcon: _searchController.text.isNotEmpty
              ? IconButton(
                  icon: const Icon(Icons.clear),
                  onPressed: () {
                    _searchController.clear();
                    ref.read(fansProvider.notifier).searchFans('');
                  },
                )
              : null,
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide.none,
          ),
          filled: true,
          fillColor: Colors.white,
        ),
        onChanged: (value) {
          // Debounce search
          Future.delayed(const Duration(milliseconds: 500), () {
            if (_searchController.text == value) {
              ref.read(fansProvider.notifier).searchFans(value);
            }
          });
        },
      ),
    );
  }

  Widget _buildFanCard(Fan fan, int index) {
    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      elevation: 2,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Rank number
            Container(
              width: 40,
              height: 40,
              decoration: BoxDecoration(
                color: _getRankColor(index),
                borderRadius: BorderRadius.circular(20),
              ),
              child: Center(
                child: Text(
                  '${index + 1}',
                  style: const TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
            const SizedBox(width: 16),
            // Fan avatar
            CircleAvatar(
              radius: 30,
              backgroundColor: Colors.grey[300],
              backgroundImage: fan.profileImage != null
                  ? NetworkImage(fan.profileImage!)
                  : null,
              child: fan.profileImage == null
                  ? Text(
                      fan.firstName.isNotEmpty ? fan.firstName[0].toUpperCase() : 'F',
                      style: const TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                        color: Colors.grey,
                      ),
                    )
                  : null,
            ),
            const SizedBox(width: 16),
            // Fan details
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Text(
                    fan.fullName,
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                    ),
                    overflow: TextOverflow.ellipsis,
                    maxLines: 1,
                  ),
                  const SizedBox(height: 4),
                  if (fan.location != null)
                    Text(
                      fan.location!,
                      style: TextStyle(
                        fontSize: 14,
                        color: Colors.grey[600],
                      ),
                      overflow: TextOverflow.ellipsis,
                      maxLines: 1,
                    ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      Expanded(
                        flex: 2,
                        child: Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 8,
                            vertical: 4,
                          ),
                          decoration: BoxDecoration(
                            color: _getLevelColor(fan.level),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Text(
                            fan.level ?? 'New Fan',
                            style: const TextStyle(
                              fontSize: 12,
                              color: Colors.white,
                              fontWeight: FontWeight.w500,
                            ),
                            overflow: TextOverflow.ellipsis,
                            maxLines: 1,
                          ),
                        ),
                      ),
                      const SizedBox(width: 8),
                      Expanded(
                        flex: 1,
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            const Icon(
                              Icons.star,
                              color: Colors.amber,
                              size: 16,
                            ),
                            const SizedBox(width: 4),
                            Flexible(
                              child: Text(
                                '${fan.points}',
                                style: const TextStyle(
                                  fontSize: 14,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.amber,
                                ),
                                overflow: TextOverflow.ellipsis,
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.people_outline,
            size: 80,
            color: Colors.grey[400],
          ),
          const SizedBox(height: 16),
          Text(
            'No fans found',
            style: TextStyle(
              fontSize: 18,
              color: Colors.grey[600],
              fontWeight: FontWeight.w500,
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'Try adjusting your search or filters',
            style: TextStyle(
              fontSize: 14,
              color: Colors.grey[500],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildErrorState(String error) {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const Icon(
            Icons.error_outline,
            size: 64,
            color: Colors.red,
          ),
          const SizedBox(height: 16),
          Text(
            'Error loading fans',
            style: Theme.of(context).textTheme.headlineSmall,
          ),
          const SizedBox(height: 8),
          Text(
            error,
            style: Theme.of(context).textTheme.bodyMedium,
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 16),
          ElevatedButton(
            onPressed: () {
              ref.read(fansProvider.notifier).refreshFans();
            },
            child: const Text('Retry'),
          ),
        ],
      ),
    );
  }

  void _showSortDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Sort Fans'),
        content: SizedBox(
          width: double.maxFinite,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              ListTile(
                title: const Text('Sort by'),
                subtitle: DropdownButton<String>(
                  value: _selectedSort,
                  isExpanded: true,
                  items: const [
                    DropdownMenuItem(value: 'points', child: Text('Points')),
                    DropdownMenuItem(value: 'name', child: Text('Name')),
                    DropdownMenuItem(value: 'created_at', child: Text('Join Date')),
                  ],
                  onChanged: (value) {
                    setState(() {
                      _selectedSort = value!;
                    });
                  },
                ),
              ),
              ListTile(
                title: const Text('Order'),
                subtitle: DropdownButton<String>(
                  value: _selectedOrder,
                  isExpanded: true,
                  items: const [
                    DropdownMenuItem(value: 'desc', child: Text('Descending')),
                    DropdownMenuItem(value: 'asc', child: Text('Ascending')),
                  ],
                  onChanged: (value) {
                    setState(() {
                      _selectedOrder = value!;
                    });
                  },
                ),
              ),
            ],
          ),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              ref.read(fansProvider.notifier).sortFans(_selectedSort, _selectedOrder);
              Navigator.pop(context);
            },
            child: const Text('Apply'),
          ),
        ],
      ),
    );
  }

  Color _getRankColor(int index) {
    if (index == 0) return Colors.amber; // Gold
    if (index == 1) return Colors.grey[400]!; // Silver
    if (index == 2) return Colors.brown[400]!; // Bronze
    return Colors.blue[600]!; // Default
  }

  Color _getLevelColor(String? level) {
    switch (level) {
      case 'Legend':
        return Colors.purple;
      case 'Super Fan':
        return Colors.red;
      case 'Loyal Fan':
        return Colors.orange;
      case 'Regular Fan':
        return Colors.green;
      default:
        return Colors.blue;
    }
  }
}