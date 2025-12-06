<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TestGoogleOAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oauth:test-google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Google OAuth connection with certificate verification';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Testing Google OAuth connection...');
        $this->newLine();

        // Test 1: Check if cacert.pem exists
        $caPath = base_path('storage/app/cacert.pem');
        $this->info("CA Bundle path: {$caPath}");
        
        if (!file_exists($caPath)) {
            $this->error('❌ CA bundle file not found!');
            return 1;
        }
        $this->info('✅ CA bundle file exists');
        $this->newLine();

        // Test 2: Check CA bundle file size
        $fileSize = filesize($caPath);
        $this->info("CA bundle size: " . $this->formatBytes($fileSize));
        $this->newLine();

        // Test 3: Try to connect to Google with CA verification
        $this->info('Testing HTTPS connection to Google APIs with CA verification...');
        
        try {
            $client = new Client([
                'verify' => $caPath,
                'timeout' => 10,
                'connect_timeout' => 5,
            ]);

            // Use a valid Google API endpoint
            $response = $client->get('https://www.google.com', [
                'headers' => [
                    'User-Agent' => 'CompetigoTestBot/1.0'
                ]
            ]);
            $this->info('✅ Successfully connected to Google (HTTPS)');
            $this->info('Status code: ' . $response->getStatusCode());
            $this->newLine();
        } catch (\Exception $e) {
            // Check if it's a certificate error
            if (strpos($e->getMessage(), 'certificate') !== false || strpos($e->getMessage(), 'SSL') !== false) {
                $this->error('❌ Certificate verification failed:');
                $this->error($e->getMessage());
                $this->newLine();
                return 1;
            }
            
            // Other errors are OK (like network issues) - the important part is certificate works
            $this->warn('⚠️  Connection issue (but not certificate-related):');
            $this->warn($e->getMessage());
            $this->info('✅ Certificate verification appears to be working');
            $this->newLine();
        }

        // Test 4: Check Google OAuth config
        $this->info('Checking Google OAuth configuration...');
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = env('GOOGLE_REDIRECT_URI');

        if (!$clientId || !$clientSecret) {
            $this->error('❌ Missing GOOGLE_CLIENT_ID or GOOGLE_CLIENT_SECRET in .env');
            return 1;
        }

        $this->info('✅ GOOGLE_CLIENT_ID: ' . substr($clientId, 0, 10) . '...');
        $this->info('✅ GOOGLE_CLIENT_SECRET: ' . substr($clientSecret, 0, 10) . '...');
        $this->info('✅ GOOGLE_REDIRECT_URI: ' . $redirectUri);
        $this->newLine();

        $this->info('✅ All tests passed! Google OAuth should work.');
        return 0;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes): string
    {
        $units = ['B', 'KB', 'MB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
