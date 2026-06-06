import 'package:flutter_blue_plus/flutter_blue_plus.dart';

class BleService {

  Future<bool> scanBeacon() async {

    bool ditemukan = false;

    FlutterBluePlus.startScan(timeout: const Duration(seconds: 4));

    FlutterBluePlus.scanResults.listen((results) {

      for (ScanResult result in results) {

        if (result.device.platformName.contains('BLE')) {
          ditemukan = true;
        }
      }
    });

    await Future.delayed(const Duration(seconds: 4));

    FlutterBluePlus.stopScan();

    return ditemukan;
  }
}