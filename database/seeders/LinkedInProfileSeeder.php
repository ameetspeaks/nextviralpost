<?php

namespace Database\Seeders;

use App\Models\LinkedInProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class LinkedInProfileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            LinkedInProfile::create([
                'user_id' => $user->id,
                'headline' => 'Senior Software Engineer | Full Stack Developer | AI Enthusiast',
                'summary' => 'Experienced software engineer with a passion for building scalable applications and implementing AI solutions. Strong background in web development, cloud computing, and machine learning.',
                'experience' => [
                    [
                        'title' => 'Senior Software Engineer',
                        'company' => 'Tech Solutions Inc.',
                        'duration' => '2020 - Present',
                        'description' => 'Leading development of AI-powered applications and mentoring junior developers.'
                    ],
                    [
                        'title' => 'Software Engineer',
                        'company' => 'Innovative Tech',
                        'duration' => '2018 - 2020',
                        'description' => 'Developed and maintained web applications using modern technologies.'
                    ]
                ],
                'education' => [
                    [
                        'institution' => 'University of Technology',
                        'degree' => 'Master of Science in Computer Science',
                        'duration' => '2016 - 2018'
                    ]
                ],
                'skills' => [
                    ['name' => 'JavaScript', 'endorsements' => 45],
                    ['name' => 'Python', 'endorsements' => 38],
                    ['name' => 'React', 'endorsements' => 32],
                    ['name' => 'Node.js', 'endorsements' => 28],
                    ['name' => 'Machine Learning', 'endorsements' => 25]
                ],
                'certifications' => [
                    [
                        'name' => 'AWS Certified Solutions Architect',
                        'issuer' => 'Amazon Web Services',
                        'date' => '2022'
                    ]
                ],
                'languages' => [
                    ['name' => 'English', 'proficiency' => 'Native'],
                    ['name' => 'Spanish', 'proficiency' => 'Professional']
                ],
                'volunteer_experience' => [
                    [
                        'role' => 'Mentor',
                        'organization' => 'Code for Good',
                        'duration' => '2021 - Present',
                        'description' => 'Mentoring aspiring developers and contributing to open-source projects.'
                    ]
                ],
                'recommendations' => [
                    [
                        'name' => 'John Smith',
                        'title' => 'CTO at Tech Solutions Inc.',
                        'text' => 'An exceptional engineer who consistently delivers high-quality solutions.'
                    ]
                ],
                'overall_score' => 85,
                'section_scores' => [
                    'headline' => 90,
                    'summary' => 85,
                    'experience' => 80,
                    'education' => 75,
                    'skills' => 95,
                    'certifications' => 70,
                    'languages' => 85,
                    'volunteer_experience' => 80,
                    'recommendations' => 75
                ],
                'improvement_suggestions' => [
                    [
                        'section' => 'Certifications',
                        'suggestions' => [
                            'Add more relevant certifications',
                            'Include certification dates',
                            'Mention any ongoing certifications'
                        ]
                    ],
                    [
                        'section' => 'Recommendations',
                        'suggestions' => [
                            'Request more recommendations',
                            'Get recommendations from different roles',
                            'Ask for specific skill endorsements'
                        ]
                    ]
                ],
                'competitor_analysis' => [
                    'Content Quality' => 'Your profile content is well-structured and professional, but could benefit from more quantifiable achievements.',
                    'Profile Completeness' => 'Most sections are well-filled, but certifications and recommendations could be strengthened.',
                    'Keyword Optimization' => 'Good use of industry-specific keywords, especially in the headline and summary.',
                    'Engagement Potential' => 'Strong potential for engagement with clear value proposition and professional tone.',
                    'Industry Alignment' => 'Well-aligned with industry standards and showcases relevant technical expertise.'
                ],
                'pdf_path' => 'linkedin-profiles/sample-profile.pdf'
            ]);
        }
    }
} 