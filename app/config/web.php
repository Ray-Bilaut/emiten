<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['app_migrate_token'] = getenv('MIGRATE_TOKEN');

$config['app_mflog_path'] = getenv('MFLOG_PATH');

$config['app_youtube_key'] = getenv('YOUTUBE_KEY');
$config['app_youtube_channel'] = getenv('YOUTUBE_CHANNEL');

$config['app_content'] = [
	'mengapa-tata-kelola' => [
		'title' => 'MENGAPA TATA KELOLA',
		'title_en' => 'WHY GOVERNANCE',
		'sidebar' => [
			'title' => 'MENGAPA TATA KELOLA',
			'title_en' => 'WHY GOVERNANCE',
			'menu' => [
	           	['link' => 'mengapa-tata-kelola/visi-misi', 'label' => 'Visi-Misi', 'label_en' => 'Vision'],
	           	['link' => 'mengapa-tata-kelola/achievements', 'label' => 'Peran Kemitraan', 'label_en' => 'Achievements'],
	            // ['link' => 'mengapa-tata-kelola/praktik-baik', 'label' => 'Praktik - Baik', 'label_en' => 'Good Practice'],
	        ]
	    ],
	    'slug' => [
	    	'visi-misi',
	    	'achievements',
	    	// 'praktik-baik'
	    ]
	],
	'tentang-kami' => [
		'title' => 'TENTANG KAMI',
		'title_en' => 'ABOUT US',
		'sidebar' => [
			'title' => 'TENTANG KAMI',
			'title_en' => 'ABOUT US',
			'menu' => [
				['link' => 'tentang-kami/sejarah', 'label' => 'Sejarah', 'label_en' => 'History'],
				['link' => 'tentang-kami/struktur-organisasi', 'label' => 'Sruktur Organisasi', 'label_en' => 'Organization Structure'],
	           	['link' => 'tentang-kami/teman-serikat', 'label' => 'Teman Serikat', 'label_en' => 'Partners'],
	            ['link' => 'tentang-kami/mitra-pembangunan', 'label' => 'Mitra Pembangunan', 'label_en' => 'Development Partners']
	        ]
	    ],
	    'slug' => [
	    	'sejarah',
	    	'struktur-organisasi',
	    	'teman-serikat',
	    	'mitra-pembangunan'
	    ]
	],
	'rencana-strategi' => [
		'title' => '5 PILAR RENCANA STRATEGI',
		'title_en' => '5 PILLARS OF A STRATEGIC PLAN',
		'sidebar' => [
			'title' => '5 PILAR RENCANA STRATEGI',
			'title_en' => '5 PILLARS OF A STRATEGIC PLAN',
			'menu' => [
	           	['link' => 'rencana-strategi/law-enforcement-anti-corruption', 'label' => 'Law Enforcement/anti-corruption', 'label_en' => 'Law Enforcement/anti-corruption'],
	            ['link' => 'rencana-strategi/sustainability', 'label' => 'Sustainability', 'label_en' => 'Sustainability'],
	            ['link' => 'rencana-strategi/inclusivity', 'label' => 'Inclusivity', 'label_en' => 'Inclusivity'],
	            ['link' => 'rencana-strategi/regionalization', 'label' => 'Regionalization', 'label_en' => 'Regionalization'],
	            ['link' => 'rencana-strategi/tech-infra', 'label' => 'Tech Infra', 'label_en' => 'Tech Infra']
	        ]
	    ],
	    'slug' => [
	    	'law-enforcement-anti-corruption',
	    	'sustainability',
	    	'inclusivity',
	    	'regionalization',
	    	'tech-infra'
	    ]
	]
];