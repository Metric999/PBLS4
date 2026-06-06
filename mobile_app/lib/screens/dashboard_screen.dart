import 'package:flutter/material.dart';

class DashboardScreen extends StatelessWidget {
  const DashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {

    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard')
      ),

      body: ListView(
        padding: const EdgeInsets.all(20),
        children: const [

          Card(
            child: ListTile(
              title: Text('BLE Terdeteksi - GU-805'),
              subtitle: Text('Sinyal ruangan berhasil ditemukan'),
            ),
          ),

          SizedBox(height: 20),

          Card(
            child: ListTile(
              title: Text('Pengujian Perangkat Lunak'),
              subtitle: Text('08:00 - 10:00'),
            ),
          )
        ],
      ),

      floatingActionButton: FloatingActionButton.extended(
        onPressed: () {},
        label: const Text('Absen Sekarang'),
      ),
    );
  }
}import 'package:flutter/material.dart';

class DashboardScreen extends StatelessWidget {
  const DashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {

    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard')
      ),

      body: ListView(
        padding: const EdgeInsets.all(20),
        children: const [

          Card(
            child: ListTile(
              title: Text('BLE Terdeteksi - GU-805'),
              subtitle: Text('Sinyal ruangan berhasil ditemukan'),
            ),
          ),

          SizedBox(height: 20),

          Card(
            child: ListTile(
              title: Text('Pengujian Perangkat Lunak'),
              subtitle: Text('08:00 - 10:00'),
            ),
          )
        ],
      ),

      floatingActionButton: FloatingActionButton.extended(
        onPressed: () {},
        label: const Text('Absen Sekarang'),
      ),
    );
  }
}