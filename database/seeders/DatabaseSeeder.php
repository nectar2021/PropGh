<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@propsgh.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@12345');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => env('ADMIN_NAME', 'Propsgh Admin'),
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
                'role' => 'admin',
                'phone' => '+233200000000',
                'avatar_path' => 'assets/img/listings/real-estate/single/avatar.jpg',
            ]
        );

        $agent = User::firstOrCreate(
            ['email' => 'agent@propsgh.com'],
            [
                'name' => 'Liza Williams',
                'password' => Hash::make('Agent@12345'),
                'is_admin' => false,
                'role' => 'agent',
                'is_verified' => true,
                'company_name' => 'PropsGh Realty',
                'phone' => '745-854-4264',
                'avatar_path' => 'assets/img/listings/real-estate/single/avatar.jpg',
            ]
        );

        $host = User::firstOrCreate(
            ['email' => 'host@propsgh.com'],
            [
                'name' => 'Marcus Hill',
                'password' => Hash::make('Host@12345'),
                'is_admin' => false,
                'role' => 'client',
                'phone' => '+233500000000',
                'avatar_path' => 'assets/img/listings/real-estate/single/avatar.jpg',
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'role' => 'client',
            ]
        );

        $properties = [
            [
                'title' => '40 S 9th St, Brooklyn, NY 11249',
                'price' => 1620,
                'area' => 65,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'garage_spaces' => 1,
                'is_verified' => true,
                'latitude' => 40.7143,
                'longitude' => -73.9582,
                'image_set' => ['assets/img/listings/real-estate/01.jpg'],
            ],
            [
                'title' => '517 82nd St, Brooklyn, NY 11209',
                'price' => 1320,
                'area' => 45,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage_spaces' => 0,
                'latitude' => 40.6197,
                'longitude' => -74.0011,
                'image_set' => ['assets/img/listings/real-estate/02.jpg'],
            ],
            [
                'title' => '3811 Ditmars Blvd Astoria, NY 11105',
                'price' => 1890,
                'area' => 75,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'garage_spaces' => 1,
                'is_featured' => true,
                'latitude' => 40.7801,
                'longitude' => -73.9060,
                'image_set' => ['assets/img/listings/real-estate/03.jpg'],
            ],
            [
                'title' => '67-04 Myrtle Ave Glendale, NY 11385',
                'price' => 1170,
                'area' => 42,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage_spaces' => 0,
                'is_verified' => true,
                'latitude' => 40.7001,
                'longitude' => -73.8695,
                'image_set' => ['assets/img/listings/real-estate/04.jpg'],
            ],
            [
                'title' => '444 Park Ave, Brooklyn, NY 11205',
                'price' => 1250,
                'area' => 54,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'garage_spaces' => 0,
                'is_verified' => true,
                'latitude' => 40.6964,
                'longitude' => -73.9571,
                'image_set' => ['assets/img/listings/real-estate/05.jpg'],
            ],
            [
                'title' => '929 Hart St, Brooklyn, NY 11237',
                'price' => 2750,
                'area' => 108,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'garage_spaces' => 1,
                'latitude' => 40.6899,
                'longitude' => -73.9217,
                'image_set' => ['assets/img/listings/real-estate/06.jpg'],
            ],
        ];

        foreach ($properties as $index => $data) {
            $title = $data['title'];
            $slug = Str::slug($title);

            $property = Property::updateOrCreate(
                ['slug' => $slug],
                [
                    'owner_id' => $index % 2 === 0 ? $agent->id : $host->id,
                    'title' => $title,
                    'description' => 'Comfortable living area, renovated kitchen, and easy access to transportation hubs.',
                    'price' => $data['price'],
                    'price_period' => 'month',
                    'deposit' => $data['price'] * 2,
                    'listing_type' => 'rent',
                    'property_type' => 'Apartment',
                    'bedrooms' => $data['bedrooms'],
                    'bathrooms' => $data['bathrooms'],
                    'garage_spaces' => $data['garage_spaces'],
                    'area' => $data['area'],
                    'year_built' => 2023,
                    'floor' => 3,
                    'total_rooms' => max(2, $data['bedrooms'] + 1),
                    'address' => $title,
                    'city' => 'Brooklyn',
                    'region' => 'NY',
                    'country' => 'USA',
                    'postal_code' => '11211',
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2311.3724100313693!2d-73.82417211551919!3d42.62335692577899!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89dde016efd1fe73%3A0x6861561b35064fe9!2sGlendale%20Ave!5e0!3m2!1sen!2suk!4v1726842151281!5m2!1sen!2suk',
                    'amenities' => [
                        'WiFi',
                        'Dishwasher',
                        'Air conditioning',
                        'Parking place',
                        'Laundry',
                        'Iron',
                        'Security cameras',
                        'No smoking',
                        'Pets allowed',
                    ],
                    'pets_allowed' => ['Cats', 'Dogs'],
                    'status' => 'live',
                    'visibility' => 'public',
                    'is_featured' => $data['is_featured'] ?? false,
                    'is_verified' => $data['is_verified'] ?? false,
                    'views' => 120 + ($index * 10),
                    'published_at' => now()->subDays($index + 1),
                ]
            );

            PropertyImage::where('property_id', $property->id)->delete();
            foreach ($data['image_set'] as $imageIndex => $path) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => $path,
                    'is_cover' => $imageIndex === 0,
                    'sort_order' => $imageIndex,
                ]);
            }
        }

        // Default site settings
        $defaults = [
            'contact_email' => 'hello@propsgh.com',
            'contact_phone' => '+233 20 000 0000',
            'brand_description' => 'Premium stays and investments across Ghana — curated, verified, and supported by local experts.',
            'social_instagram' => '',
            'social_facebook' => '',
            'social_twitter' => '',
            'social_youtube' => '',
            'stat_rating' => '4.9/5',
            'stat_rating_label' => 'Guest rating',
            'stat_support' => '24/7',
            'stat_support_label' => 'Support',
            'stat_satisfaction' => '98%',
            'stat_satisfaction_label' => 'Satisfaction',
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // Legal pages
        LegalPage::firstOrCreate(['slug' => 'terms'], [
            'title' => 'Terms & Conditions',
            'meta_description' => 'Terms and conditions for using the Propsgh platform.',
            'sections' => [
                ['anchor' => 'acceptance', 'title' => 'Acceptance of Terms', 'content' => '<p>By accessing or using Propsgh ("the Platform"), you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services. These terms constitute a legally binding agreement between you and Propsgh.</p><p>We may update these terms from time to time. Continued use of the Platform after changes constitutes acceptance of the revised terms.</p>'],
                ['anchor' => 'eligibility', 'title' => 'Eligibility', 'content' => '<p>To use Propsgh, you must:</p><ul><li>Be at least <strong>18 years of age</strong> or the legal age of majority in your jurisdiction</li><li>Have the legal capacity to enter into a binding contract</li><li>Provide accurate, current, and complete information during registration</li><li>Not be prohibited from using the Platform under applicable laws</li></ul>'],
                ['anchor' => 'accounts', 'title' => 'User Accounts', 'content' => '<p>When you create an account with Propsgh, you are responsible for maintaining the confidentiality of your login credentials and for all activities that occur under your account.</p><ul><li>You must provide truthful and accurate information in your profile</li><li>You may not share your account credentials with third parties</li><li>You must notify us immediately of any unauthorised access to your account</li><li>Propsgh reserves the right to suspend or terminate accounts that violate these terms</li></ul>'],
                ['anchor' => 'listings', 'title' => 'Property Listings', 'content' => '<p>Hosts who list properties on Propsgh agree to the following:</p><ul><li>All listing information, photos, and descriptions must be <strong>accurate and not misleading</strong></li><li>You must have the legal right to rent, sell, or advertise the property</li><li>Pricing must be transparent and include all mandatory fees</li><li>Listings must comply with all applicable local laws and regulations in Ghana</li><li>Propsgh reserves the right to remove or de-list properties that do not meet our quality standards or violate these terms</li></ul><p>Propsgh may verify listings at its discretion. A "Verified" badge indicates we have taken reasonable steps to confirm the listing\'s authenticity, but does not constitute a guarantee.</p>'],
                ['anchor' => 'bookings', 'title' => 'Bookings & Payments', 'content' => '<p>Propsgh facilitates connections between property hosts and guests. When making a booking or enquiry:</p><ul><li>All financial transactions are between the host and the guest unless Propsgh acts as an intermediary</li><li>Deposits, rental payments, and refund policies are set by individual hosts and should be reviewed before committing</li><li>Propsgh is not responsible for disputes arising from payment arrangements made directly between users</li><li>Where applicable, service fees may be charged for bookings made through the Platform</li></ul>'],
                ['anchor' => 'conduct', 'title' => 'User Conduct', 'content' => '<p>When using Propsgh, you agree not to:</p><ul><li>Post false, misleading, or fraudulent content</li><li>Harass, threaten, or discriminate against other users</li><li>Attempt to gain unauthorised access to other accounts or systems</li><li>Use the Platform for any unlawful purpose</li><li>Scrape, harvest, or collect user data without authorisation</li><li>Interfere with the proper functioning of the Platform</li></ul><p>Violations may result in account suspension, removal of content, or permanent banning from the Platform.</p>'],
                ['anchor' => 'ip', 'title' => 'Intellectual Property', 'content' => '<p>All content on Propsgh — including text, graphics, logos, icons, images, and software — is the property of Propsgh or its licensors and is protected by copyright and intellectual property laws.</p><p>Users retain ownership of content they upload (e.g., property photos and descriptions) but grant Propsgh a <strong>non-exclusive, worldwide, royalty-free licence</strong> to use, display, and distribute such content in connection with the Platform.</p>'],
                ['anchor' => 'disclaimers', 'title' => 'Disclaimers', 'content' => '<p>Propsgh provides the Platform on an <strong>"as is" and "as available"</strong> basis. We do not warrant that:</p><ul><li>The Platform will be uninterrupted, secure, or error-free</li><li>Listing information provided by hosts is accurate or complete</li><li>The Platform will meet your specific requirements</li></ul><p>Propsgh acts primarily as a marketplace connecting hosts and guests. We are not a real estate agency, landlord, or property management company. We do not own, manage, or control the properties listed on the Platform.</p>'],
                ['anchor' => 'liability', 'title' => 'Limitation of Liability', 'content' => '<p>To the maximum extent permitted by law, Propsgh shall not be liable for:</p><ul><li>Any indirect, incidental, special, or consequential damages arising from the use of the Platform</li><li>Loss of data, profits, or business opportunities</li><li>Actions or omissions of other users, including hosts and guests</li><li>Property damage, personal injury, or financial loss resulting from transactions arranged through the Platform</li></ul><p>Our total liability shall not exceed the amount you paid to Propsgh (if any) in the twelve (12) months preceding the claim.</p>'],
                ['anchor' => 'termination', 'title' => 'Termination', 'content' => '<p>Propsgh may terminate or suspend your account at any time, with or without notice, for conduct that we believe violates these Terms or is harmful to other users, the Platform, or third parties.</p><p>You may close your account at any time by contacting our support team. Upon termination, your right to use the Platform ceases immediately, though certain provisions of these terms (such as intellectual property, disclaimers, and limitation of liability) will survive.</p>'],
                ['anchor' => 'changes', 'title' => 'Changes to Terms', 'content' => '<p>We reserve the right to modify these Terms and Conditions at any time. Material changes will be communicated via email or a prominent notice on the Platform. Your continued use after such changes constitutes acceptance of the new terms.</p><p>We encourage you to review these terms periodically to stay informed of any updates.</p>'],
                ['anchor' => 'contact', 'title' => 'Contact Us', 'content' => '<p>If you have questions about these Terms and Conditions, please reach out via our contact page or email us directly.</p>'],
            ],
        ]);

        LegalPage::firstOrCreate(['slug' => 'privacy'], [
            'title' => 'Privacy Policy',
            'meta_description' => 'Privacy policy for the Propsgh platform — how we collect, use, and protect your data.',
            'sections' => [
                ['anchor' => 'overview', 'title' => 'Overview', 'content' => '<p>Propsgh ("we", "us", "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your personal information when you use our platform, whether as a guest browsing listings or a host advertising properties.</p><p>By using Propsgh, you consent to the data practices described in this policy.</p>'],
                ['anchor' => 'collect', 'title' => 'Information We Collect', 'content' => '<p><strong>Information you provide directly:</strong></p><ul><li>Account details — name, email address, phone number, and password</li><li>Profile information — avatar, bio, and role preferences</li><li>Property listing data — descriptions, photos, pricing, location, and amenity details</li><li>Contact form submissions — name, email, and message content</li><li>Newsletter subscription — email address</li></ul><p><strong>Information collected automatically:</strong></p><ul><li>Device and browser information (user agent, screen resolution)</li><li>IP address and approximate geographic location</li><li>Pages visited, time spent, and interaction patterns</li><li>Referring website or search terms</li></ul>'],
                ['anchor' => 'use', 'title' => 'How We Use Your Data', 'content' => '<p>We use the information we collect to:</p><ul><li>Provide, operate, and maintain the Propsgh platform</li><li>Process property listings and facilitate connections between hosts and guests</li><li>Send transactional emails (account confirmations, booking updates)</li><li>Send marketing communications (newsletters, promotions) — only with your consent</li><li>Improve our services through analytics and usage patterns</li><li>Detect and prevent fraud, abuse, and security threats</li><li>Comply with legal obligations</li></ul>'],
                ['anchor' => 'sharing', 'title' => 'Data Sharing', 'content' => '<p>We do <strong>not sell</strong> your personal data. We may share information with:</p><ul><li><strong>Other users</strong> — Hosts and guests can see relevant profile information to facilitate connections</li><li><strong>Service providers</strong> — Trusted third parties that help us operate the platform (hosting, email delivery, analytics)</li><li><strong>Legal authorities</strong> — When required by law, court order, or to protect our rights and safety</li></ul><p>All third-party service providers are contractually obligated to handle your data securely and only for the purposes we specify.</p>'],
                ['anchor' => 'cookies', 'title' => 'Cookies & Tracking', 'content' => '<p>Propsgh uses cookies and similar technologies to:</p><ul><li>Keep you signed in and remember your preferences</li><li>Understand how the platform is used (analytics)</li><li>Deliver relevant content and improve performance</li></ul><p>You can manage cookie preferences through your browser settings. Disabling cookies may limit certain features of the Platform.</p>'],
                ['anchor' => 'security', 'title' => 'Data Security', 'content' => '<p>We implement appropriate technical and organisational measures to protect your personal information, including:</p><ul><li>Encryption of data in transit (HTTPS/TLS)</li><li>Secure password hashing</li><li>Regular security assessments and vulnerability monitoring</li><li>Access controls limiting who can view personal data</li></ul><p>While we strive to protect your information, no method of electronic storage or transmission is 100% secure. We cannot guarantee absolute security.</p>'],
                ['anchor' => 'retention', 'title' => 'Data Retention', 'content' => '<p>We retain your personal data for as long as your account is active or as needed to provide our services. Specifically:</p><ul><li><strong>Account data</strong> — retained until you delete your account</li><li><strong>Contact messages</strong> — retained for up to 24 months</li><li><strong>Newsletter subscriptions</strong> — retained until you unsubscribe</li><li><strong>Server logs</strong> — retained for up to 90 days</li></ul><p>When data is no longer needed, it is securely deleted or anonymised.</p>'],
                ['anchor' => 'rights', 'title' => 'Your Rights', 'content' => '<p>Depending on your location, you may have the right to:</p><ul><li><strong>Access</strong> — Request a copy of the personal data we hold about you</li><li><strong>Correction</strong> — Request corrections to inaccurate or incomplete data</li><li><strong>Deletion</strong> — Request that we delete your personal data</li><li><strong>Objection</strong> — Object to processing of your data for marketing purposes</li><li><strong>Portability</strong> — Request your data in a structured, machine-readable format</li><li><strong>Withdraw consent</strong> — Opt out of marketing communications at any time</li></ul><p>To exercise any of these rights, please contact us using the details below. We will respond within 30 days.</p>'],
                ['anchor' => 'children', 'title' => 'Children\'s Privacy', 'content' => '<p>Propsgh is not intended for individuals under the age of 18. We do not knowingly collect personal information from children. If you believe a child has provided us with personal data, please contact us and we will promptly delete it.</p>'],
                ['anchor' => 'changes', 'title' => 'Policy Changes', 'content' => '<p>We may update this Privacy Policy from time to time to reflect changes in our practices or for legal, operational, or regulatory reasons. We will notify you of material changes by email or through a prominent notice on the Platform.</p>'],
                ['anchor' => 'contact', 'title' => 'Contact Us', 'content' => '<p>For privacy-related questions or requests, please get in touch via our contact page or email us directly.</p>'],
            ],
        ]);
    }
}