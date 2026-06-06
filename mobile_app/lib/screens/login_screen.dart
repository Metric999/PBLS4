import 'package:flutter/material.dart';
          content: Text('BLE Beacon tidak ditemukan')
        )
      );

      setState(() {
        loading = false;
      });

      return;
    }

    final response = await api.login(
      usernameController.text,
      passwordController.text
    );

    print(response);

    setState(() {
      loading = false;
    });
  }

  @override
  Widget build(BuildContext context) {

    return Scaffold(
      body: Padding(
        padding: const EdgeInsets.all(20),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [

            TextField(
              controller: usernameController,
              decoration: const InputDecoration(
                labelText: 'Username'
              ),
            ),

            const SizedBox(height: 20),

            TextField(
              controller: passwordController,
              obscureText: true,
              decoration: const InputDecoration(
                labelText: 'Password'
              ),
            ),

            const SizedBox(height: 30),

            ElevatedButton(
              onPressed: login,
              child: loading
                ? const CircularProgressIndicator()
                : const Text('Login'),
            )
          ],
        ),
      ),
    );
  }
}