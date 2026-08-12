<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductView;
use App\Models\Store;
use App\Models\User;
use App\Models\WhatsappClick;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Electronics', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA3qYe0QD4LoujRFGe_lmNXdig6q-D-EYhsJewohg3i8K0Z2R76HaNMlYJ9Hatf_7rqUv2Ll0grj4yINLM9y9AhF6qfXMHwIWEt24SIL9PDfL2DrIOknE-zj6rWd8tEaicA4_JTVlan_o0TEAzMg85GGfsWW5mdXwPIbiPqhGArO-MP4u1sJ_-yHDUJkvO5kznfyW3MFtV2WdO3W7bXCFUtxE81eejY5tcz3OFWamRXkQ9qa6DUdruO'],
            ['name' => 'Phones & Accessories', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAvXOIAg1CY_mZbcDvcy8PdWRPtaHv38jeehCrUobKJmp9ei3u5CXDcGHwcM1LAmkE8YBjW4rDatg1FM8sVh97r4WEV8gl8kUFQ-3Zl5VhwvoxpDVxHO6DzWuP4ils1F15LPQlQbFTlSTPuBI6JwxF68qgDA5-PZ--FLSSpnRKWHDxMgfbjQw8NoZOdgyaXNFBx40eociQL51RqnGBfqFnCG_kcIR1Uh8_kOnLnl4xnqYTIVBYZb1Jh'],
            ['name' => 'Earphones', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAWil4eV84HgU29CFqgDGpCC0zjZ_pzGWSMDdJC0RGqo6KjhqZ9ZRu8PAumE3-qAuTA8MW3_trzgrv1Z_Ys1E-DGzQjocWtZNDEeiXQ24wWillrcz58VCsTAS-St-fBIDhELd87YwhX9BeJSyLhym4lPUGWft1XLaX_8PD8rnTlK6na0wH0-Eu2Ik1wEvku4Dz3mABqOGoTiyUfHEwT_ccrCMjwpCi2hNyl9hB-SKllZD__zIhINNWy'],
            ['name' => 'Smart Watches', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDlxyocH1ovw4ijkiHZxybr6OscBgMifNFlKdbOONBFsUY-S3QrEPZM6dnuHgomA_O0AXvYOZE_JadYjLlA2G231meYS1WSFr80SS9PdwHcyZckqmkP8fIhYsVzgnDeaqO4lHH9FQg0isgv9G6Ys3gQxDLMlE0MsrKG1faHfd_IAzMoyfM2ycVMqZAwOk2RxAiCqM4j8T5fwcLAFSv-pCFxPxvAy1kDjaU4DZeI14rurLLPJPGBNwzs'],
            ['name' => 'Fashion', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDtdKuosdwExqFQewAVcSBG1pTBxXZlBFkFQfWNVhBB9cxqEZDb6wJujQMZZ45yn0lp0qEbFDGQ1v2keFYr0tjbOotVyChjyQYD56jgCPpotX--kmA-pkcxWBeqABvaEx_tDTdNiL6wDNMRbRqIXZsHUaNNSVsyO66IIBZ8KWQpTz-0YJ35PmQyJwoalgZJFIks6_N-6zsGnoBOwaAQNbGOs5DJldiOdqcH-iXtI2G21JxstMaR7Lvn'],
            ['name' => 'Beauty', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCn368gZpY8B56FsgulQLIaG4Oa0f-4T51z1GTLD3Y8SPdcS5H2ID2PHP-Su2otVvK8OlBlYt53c9uaPCI_jbMWeRGN7yf9Meh3PP0aizZMmrmZtrto0FROXJFKv-fyuwHnv_cy0lmdlBmQrwiCgYHPx293QesRs_8-C6XQH_Mabyt04DYol-JTQnNlSXU58aNIeFRvmxJoaEvBEDsBD4MqQeW3VYIDLUGkolCoiZTWGj36mN7VxBu3'],
            ['name' => 'Home', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBKZYuC-kdZW-nztB4xok61wbMeBRQq_MjgPsG3ZCl0eHta7ZcGRPILmFbaLtXBJUQaOcIVzskruLdxqbCZa5tKqbV1pSiaoqO1GwyOVT5QNKYY9pmXvOgeUJBq79Kte-Rwi-l5iOmukpezmRAV1GKx2s0UIiBP-XBuEwAJtRKC9ky8mHAnDrnFIsINcXPiMVMOyOm8Uagt5p2n5Et79xFxfpW-wMqV_mQJnTbkJKDVP2lx29Ws2cd'],
            ['name' => 'Kitchen', 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCNQUWoOXXV3yPUdHYeeWRiR4BHVY3ISJe2gKanahqytyb08Qod6Nig23fFvf-Fc1J_QVNZU1BDe7h3Qal4oDnKs58B4D_OMeM6QJWWHy3CnHZEh_p74GYQ-lJlpaSjIX0y9gB1ZNL-5HFhuw8DhkxCNm08kJIO2jhRJdWPmxLCWhZLNFDM0L5VH75QrWf27KNCwWIkGLyxi9LMumeFZrx2YoaZus2BYa3kkPZ_vTqP6eLvGh53KSu8'],
        ])->map(fn ($data) => Category::create([
            'name' => $data['name'],
            'image' => $data['image'],
        ]));

        $electronics = $categories->firstWhere('name', 'Electronics');
        $phones = $categories->firstWhere('name', 'Phones & Accessories');
        $earphones = $categories->firstWhere('name', 'Earphones');
        $watches = $categories->firstWhere('name', 'Smart Watches');
        $fashion = $categories->firstWhere('name', 'Fashion');
        $home = $categories->firstWhere('name', 'Home');

        $techHubUser = User::create([
            'name' => 'Said Mustafa',
            'email' => 'said@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        $techHub = Store::create([
            'user_id' => $techHubUser->id,
            'name' => 'TechHub Dar',
            'bio' => 'Premium electronics and gadgets, imported and sold with confidence. Fast delivery across Dar es Salaam.',
            'location' => 'Posta, Dar es Salaam',
            'whatsapp_number' => '255712345001',
            'tags' => ['Electronics', 'Fast Shipping', 'Trusted Seller'],
        ]);

        $urbanFitsUser = User::create([
            'name' => 'Baraka Mushi',
            'email' => 'urbanfits@example.com',
            'password' => Hash::make('password'),
        ]);

        $urbanFits = Store::create([
            'user_id' => $urbanFitsUser->id,
            'name' => 'Urban Fits TZ',
            'bio' => 'Streetwear, sneakers, and lifestyle accessories for the modern Tanzanian.',
            'location' => 'Kariakoo, Dar es Salaam',
            'whatsapp_number' => '255712345002',
            'tags' => ['Fashion', 'Sneakers', 'Wholesale'],
        ]);

        $techHubProducts = [
            ['name' => 'AeroStride X1 Sneakers', 'category' => $fashion, 'price' => 125000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCV8Xbil1pVt45KK-beEk2tSq_iwY0fQ8ENL2XPWLxK4418GK7XbXBqQXXRVXfLpF8jJxwvtq8HG044IG_RAbyekdfg9ei2W1EWRuIgNecblVQvQTme_uU4mlhqN35TUURJH9B91xVVLv-4MJOUsUiT-szlqMUdF_BElJbULJShPq4-CogHaZ2o7WUZVOiLMgYymHuoBslHy5pfddh13EVYHZmUp38LotT6UE_OgFabBdMEacG_4a1a', 'featured' => true],
            ['name' => 'ChronoTech Pro V2 Smartwatch', 'category' => $watches, 'price' => 350000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDW97RSmG-Q12cTXZg0svQnNiNnhXKlr2Um4KZBf9pCNRa3vMOdhUMqP9hr8vC7pTkeOujb00rnVpsXBq-j0GNQt18HrjAcZ6nUcQcW0l9cyFYwutSXb5xNGnvAhc-2ljEX3e9Z2J1yQ1lhiwg-8EXpzD0pWDLy4_x4yi2K3RLJYHSZUZS09OvqgvO-39HvhbpU77NaTHAK9bIKRnuHTBSabcYagCSKihIuyaeR9CHw1wO6T9sSNZXy'],
            ['name' => 'Sonic Pro Wireless ANC Headphones', 'category' => $earphones, 'price' => 299990, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBpzfunF54aAczTDnJAgv9YOmCNvCYNTpWIEc9mpLvoD24l4UWTe1xDdqJGlpJGpV-9RzSA0JAPJH2le9E8ooWkry8Nl7VGsxpLX2hZvjw5EOb3RN3m_E9MNf_40GyQWDoaRumFgvfAEBpJ4I2CVnE_ndIIhzLwS4qZjLcY7xJolhJc98e4V0zJ4nFWziHZ9h574VkcUMsriWTGyzi9i0Ixdh98U38TF-yiwXt22Gx5VHhCrt_x4h97', 'deal' => true],
            ['name' => 'Active Fit Smartwatch', 'category' => $watches, 'price' => 119990, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAUtgvRLb8H1FRIMZAdD6DVq3CVkxsSidIlzABV40DH2HbhHaJHw-1Ka_G61nz39NT568a2esrVLu2GXsj9fNRvWu2gAWYamK3PUvtxSBXeCGiSAsXpOPVcoeA3D3Dn62tWnC5KGOqK4ODusLuRR7HFOEP1k_sqOTql8VtYmy4mIuEbNleHN92imKy_LXRqDx-WDI7ykogO0QubeHt2S8RtJ0iWqY_d1gtwEsmSdUXuyf710gqercQ7', 'deal' => true],
            ['name' => 'AuraX Pro Wireless Headphones', 'category' => $earphones, 'price' => 299990, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCM8ki7tMJGSblzH2f3unx2gfiSxkQEu-FjPEgpEX9w7Ea4qzx6lRzAqxeMbBFqZykBdCabWtAE7umKJ65x1kak9IQ488bKSZwbR62b5cHf8S6bNxzCmaOQ6OkVz37g-OrgsFD36DFLuvviccByF1APzL8OqnoEwYeUvHqvk742WGOCPENhVtrfJGDGqqdY8BhbdJNaNaGe1pNZBhTCgu2DQMqMypmHFjzxzCzfgeuf7Fi5Hyid_4_q'],
            ['name' => 'Chrono Fit Smartwatch Series 5', 'category' => $watches, 'price' => 149000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB27txbhinY9MUEDPgI4xbxx3REAQ5_Tbl7WOuoAtdmKt3HCsGHzCZGbDC5CLEodcKYwmNd0nRS-9sgpH8waM2E3GnN4rcru1cAg7O5dZ8jg8te6VA-PFmQW18zZu6SX1gLc9lxDP320RJyz7ghO2Ec2xvrf7ax7GFmh4G5sKCy9Rzn8jTLymubVRpV07ZJyLmpQT3ycveprKilNBfF5b0wcmNZwh1rtlK7csVFluNehfm7UfYMero1'],
            ['name' => 'Samsung Galaxy S24 Ultra 5G', 'category' => $phones, 'price' => 1250000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPJCqvnOQcSW9v8I7zQkMDBFdxLazA2wZBY1seKjEih9JL9f0Bcob5_81UmxTLSnY6z8wj8cQa91eSIOmJmdves4ZCKBeTVu000zS5mCmxCQGTo2Y7VdUDdFbDSB0eTBgRy6pRGiCos9uSHT-SiVMnbZtuziDXfWVt_AWJvan4O-W-DKgK0r0PBleF2adzQEHzJllG6fJIs2HVk8D4ju2eLdKh4aaVWoosgm46a7rel4cfl1JtG35X', 'featured' => true, 'specs' => ['Storage' => '256GB NVMe', 'RAM' => '12GB LPDDR5X', 'Display' => '6.8" AMOLED 2X', 'Camera' => '200MP Main']],
            ['name' => 'Sony WH-1000XM5', 'category' => $earphones, 'price' => 850000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBnTi14wFQxLv1WiZjJoKmoe0vjVxyn749PUx6cZPlehkNVZHk_IZECFq95n-dEcy8rQMHZ1ReAbOViHLSfK4VvxG7I4_hBWtgKX4cPrr715EVBytnQ7WD5F7m8wh-VuSJmOx5t7xonIgLrUmtkoTXZ2tHbQpJOsZIa7e07Sly-MM05Jy2TcZl92USCWwJW9If7gIutG9EDZocXtpqW0U5Ate2NbSMEV-HEY8ym1riOj26DAvUmYDg3'],
            ['name' => 'Galaxy Watch 6 Classic', 'category' => $watches, 'price' => 650000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAmHNkSe2Q0hq5-mPpvtBlRHdNR-LzX178fT6xIdnbACyU2A-LYTkGmtE01dlbGfiZob2paw5F7h31j3IddDAWurSTQ-p8aYzDZI4D1kiZ3qwvhaFAyegeJbJEOs1WSOm80ika0ldYI8cDWLbzKQNS6UsUl6aEWhlSkxXytV9vFVsTLrX7I_6qiMwq1Aq4wwrYaygu7UNHxmwdpOXczQt8pSmv1uVv3JciXI8NM7s374CHdaMDZRgYK'],
            ['name' => 'AuraX Pro Smartwatch', 'category' => $watches, 'price' => 199000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_5Qs5OF1vQ7slhCUZUU2EjSBkrgSrOXvMiGyLC0rqPof7Vc64-0wItAOk5CX67puxQSHDd2xHLwGTggwSFFDxYZkKKb_XyvM3JULL1j1DUqWEOeiQIl8Tzg62o-VoQb4B82PY4G3NVntfTsaZYIP-0ny1VDbwTYBsRxTSJLAKlykHCV97zs36NLgzcvaksgnR03tKx9ICZaIwAXCPxIFw_WiqOCZztuSox81l4kD4SPCmgb3k3tVt'],
            ['name' => 'SonicBuds Elite', 'category' => $earphones, 'price' => 89000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDXeL_xEIKA_8HxN4LqRqKpEJ52_2WkNg2tOvi2Kq8AzGWvBQOPdYwmXhdV5wxPzVz6Rgn0YwYSBIiOG-9kYeChHYMmq-1QpBSUlIHaHQPLFjXwdUnk1pCAJnu-XbQX9MFujNoH-Y0dWBbVQTamgdZd5bltC7llVLRh23K4fUkJm6XkxujSwtoGvqnMp2ZUh1Qtg1ugbg3v3fzb6s6q99GAAbaNvuL8bCtps5UVdt7PiE9mbFXVoiZl'],
            ['name' => 'Lumina Task Lamp', 'category' => $home, 'price' => 89500, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB5C7_H3VIbmrIVAZs0JWTJrL2gvq1xR4T16iWcx1Fq6xfTVat0adiwtuhnlbp1hahBwgPrpgpL5SHMSm4CMalT75QJFhS8URESnNtQUHspRO5nFM6kPajK9puLN9rSMeozLC1fFMx5fIWA_Gu2WQPc6UUEYrojsmVnJjFajsorzkxRjkWJmNBBrDiYcmZe1O0WTLs46BEpA21zyqRWrR-iZ8nKsNCzw85Vd1hjS7xXPYR3-EIexG3E'],
        ];

        $urbanFitsProducts = [
            ['name' => 'Sneaker Drop — Neon Runner', 'category' => $fashion, 'price' => 145000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuACbDUCJLeEJyvPYvCQTn6RTAixUvOWlFLo6oJUD6Z3yOGYrf5_rQ2pbigtvf6yBvxTRWdQ82aKOUNkYchnKxqRDcElKHasfOGrApl_F6NtFNLTPYHzjpkzyn7GHF-1Uvq8nkPSCsPHR5bErMjzUhiok4CmpMFUXwA8iy2sGL95yfpR8f85M5v3p-SBeHKMtBGZQnpCVmyX3-49dW-K9CuhymfCz8-krjE1HoBOJL0ozEuof9tjYSBu', 'featured' => true],
            ['name' => 'Essentials Beauty Skincare Set', 'category' => $home, 'price' => 65000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRYomKTzGJr4JqxdcDU6RO3Y_mzcl6UM2Qij4jnBiUTY56WAfDyMGyozbswad2NtHmSVWvVr22OgwsHL-TK0tmhWWn5mVikhwp5djeAXYa-W6Mzn-r7-WBQ_Fu_YEzLQf819kdvau4EOmr_JBZ9U3W0qIguJ3Sa04Dz6nvAoS3jgqnyqlYSxwyu5I0LSLarSEXSGc9R8Y8oj-yhjO5ttyl0qAmIm1ARx7DPFhHkdS1FwzDPaR-ez0l'],
            ['name' => 'Artisan Roasters Coffee Blend', 'category' => $home, 'price' => 22000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAKze1xJOMrIM4wV13LlXezYNqlu_qWy0n2iYMA9dyp1QJGUsXoov9LKXhHPpoHyH302KgBA_KJB47qas-INbTjGr2lbBDioz-kufZChTKP4X8eSgCfnmS8mKjQNbNMiyxDMtbHdjPq9ntIm1_xw2YxY4rK-4TKdWKhanKK466Xhd5vHhdJE9zfckIXLNpVHUV8-weBaJLZs74waxO8J67RF_p19SQRckVsTGGop1HocJ10jPbRMUxh', 'deal' => true],
            ['name' => 'ChronoTech Active Smartwatch', 'category' => $watches, 'price' => 175000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDqQFWSxgAIT6Q1PwVxoI1NcK8tZKrwtDsU1pYSlaLk68XyrUk8t69bZo1jh7KBx79BLvnsGCtEexbNEITN2Xb77WmJBXANL8JAa92CRs2wjuggwszCfDzbax8Wwv97z97yXjWzejOYVFsAbmbwT9864EFLQPT4wTy9ucyN1sdHIJcP3TJ0qv-7PfDaluA5o3lO4kCRSJvQ2JTF3Dt3G9je0z5J3EdekWXDWbugOtYBDc_Dek2sBmLs'],
            ['name' => 'Flagship Wireless Earbuds', 'category' => $earphones, 'price' => 135000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBpign31OpP3sI_yQNOXE3fd7_ZC1_vQ2lgOBRka-JISs0d4xEnJ-JnAV3YxbHbjSUhlfaBlQo8f-OI3LDSw-PvyzucbhyqfpvvO5LuISMQi756GZXtWYjHdydAvRW3kBvAWpqHvSa3SWNR4S4r_9Q0EvddHckMqLy-hP-FvZsUj_i01GKZjQJe1Kb1oFhwb1KfRyxs2Q5VCJa8n88A3oG-a6ac8AEsmbb143PJSr-SX6FNw_y8smHW'],
            ['name' => 'Classic Denim Jacket', 'category' => $fashion, 'price' => 78000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDtdKuosdwExqFQewAVcSBG1pTBxXZlBFkFQfWNVhBB9cxqEZDb6wJujQMZZ45yn0lp0qEbFDGQ1v2keFYr0tjbOotVyChjyQYD56jgCPpotX--kmA-pkcxWBeqABvaEx_tDTdNiL6wDNMRbRqIXZsHUaNNSVsyO66IIBZ8KWQpTz-0YJ35PmQyJwoalgZJFIks6_N-6zsGnoBOwaAQNbGOs5DJldiOdqcH-iXtI2G21JxstMaR7Lvn'],
            ['name' => 'Everyday Backpack', 'category' => $fashion, 'price' => 55000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAvXOIAg1CY_mZbcDvcy8PdWRPtaHv38jeehCrUobKJmp9ei3u5CXDcGHwcM1LAmkE8YBjW4rDatg1FM8sVh97r4WEV8gl8kUFQ-3Zl5VhwvoxpDVxHO6DzWuP4ils1F15LPQlQbFTlSTPuBI6JwxF68qgDA5-PZ--FLSSpnRKWHDxMgfbjQw8NoZOdgyaXNFBx40eociQL51RqnGBfqFnCG_kcIR1Uh8_kOnLnl4xnqYTIVBYZb1Jh', 'deal' => true],
            ['name' => 'Studio Sneakers White', 'category' => $fashion, 'price' => 98000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCV8Xbil1pVt45KK-beEk2tSq_iwY0fQ8ENL2XPWLxK4418GK7XbXBqQXXRVXfLpF8jJxwvtq8HG044IG_RAbyekdfg9ei2W1EWRuIgNecblVQvQTme_uU4mlhqN35TUURJH9B91xVVLv-4MJOUsUiT-szlqMUdF_BElJbULJShPq4-CogHaZ2o7WUZVOiLMgYymHuoBslHy5pfddh13EVYHZmUp38LotT6UE_OgFabBdMEacG_4a1a'],
            ['name' => 'Premium Skincare Trio', 'category' => $home, 'price' => 48000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCn368gZpY8B56FsgulQLIaG4Oa0f-4T51z1GTLD3Y8SPdcS5H2ID2PHP-Su2otVvK8OlBlYt53c9uaPCI_jbMWeRGN7yf9Meh3PP0aizZMmrmZtrto0FROXJFKv-fyuwHnv_cy0lmdlBmQrwiCgYHPx293QesRs_8-C6XQH_Mabyt04DYol-JTQnNlSXU58aNIeFRvmxJoaEvBEDsBD4MqQeW3VYIDLUGkolCoiZTWGj36mN7VxBu3'],
            ['name' => 'Kitchen Essentials Cookware Set', 'category' => $electronics, 'price' => 210000, 'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCNQUWoOXXV3yPUdHYeeWRiR4BHVY3ISJe2gKanahqytyb08Qod6Nig23fFvf-Fc1J_QVNZU1BDe7h3Qal4oDnKs58B4D_OMeM6QJWWHy3CnHZEh_p74GYQ-lJlpaSjIX0y9gB1ZNL-5HFhuw8DhkxCNm08kJIO2jhRJdWPmxLCWhZLNFDM0L5VH75QrWf27KNCwWIkGLyxi9LMumeFZrx2YoaZus2BYa3kkPZ_vTqP6eLvGh53KSu8'],
        ];

        $this->createProducts($techHub, $techHubProducts);
        $this->createProducts($urbanFits, $urbanFitsProducts);
    }

    protected function createProducts(Store $store, array $items): void
    {
        foreach ($items as $item) {
            $price = $item['price'];
            $isDeal = $item['deal'] ?? false;

            $product = Product::create([
                'store_id' => $store->id,
                'category_id' => $item['category']->id,
                'name' => $item['name'],
                'description' => "The {$item['name']} — a top pick from {$store->name}, available now on WingaX with fast local delivery.",
                'price' => $price,
                'discount_price' => $isDeal ? (int) round($price * 0.75) : null,
                'location' => $store->location,
                'availability' => fake()->randomElement(['in_stock', 'in_stock', 'in_stock', 'limited']),
                'is_featured' => $item['featured'] ?? false,
                'is_deal' => $isDeal,
                'status' => 'published',
                'specs' => $item['specs'] ?? null,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $item['image'],
                'sort_order' => 0,
            ]);

            $views = fake()->numberBetween(5, 200);
            ProductView::factory()
                ->count($views)
                ->state([
                    'product_id' => $product->id,
                    'store_id' => $store->id,
                ])
                ->create();

            $clicks = (int) round($views * fake()->randomFloat(2, 0.05, 0.3));
            WhatsappClick::factory()
                ->count($clicks)
                ->state([
                    'product_id' => $product->id,
                    'store_id' => $store->id,
                ])
                ->create();
        }
    }
}
