import 'package:dio/dio.dart';

class ApiService {

  final Dio dio = Dio(
    BaseOptions(
      baseUrl: 'http://10.0.2.2:8000/api'
    )
  );

  Future login(String username, String password) async {

    final response = await dio.post(
      '/login',
      data: {
        'username': username,
        'password': password
      }
    );

    return response.data;
  }

  Future absen(String token, String uuidBeacon) async {

    final response = await dio.post(
      '/absen',
      data: {
        'uuid_beacon': uuidBeacon
      },
      options: Options(
        headers: {
          'Authorization': 'Bearer $token'
        }
      )
    );

    return response.data;
  }
}