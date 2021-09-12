<?php

namespace Database\Seeders;

use App\Models\Tag;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Class TagSeeder
 * @package Database\Seeders
 */
class TagSeeder extends Seeder
{
    /**
     * Test tags
     */
    private $tags = [
        [
            'title' => 'AJAX',
            'icon' => 'ajax.png'
        ],
        [
            'title' => 'Алгоритмы',
            'icon' => 'algorithms.png'
        ],
        [
            'title' => 'Android',
            'icon' => 'android.png'
        ],
        [
            'title' => 'Книги',
            'icon' => 'books.png'
        ],
        [
            'title' => 'Браузеры',
            'icon' => 'browsers.png'
        ],
        [
            'title' => 'CSS',
            'icon' => 'css.png'
        ],
        [
            'title' => 'Дизайн',
            'icon' => 'design.png'
        ],
        [
            'title' => 'GIT',
            'icon' => 'git.png'
        ],
        [
            'title' => 'Google',
            'icon' => 'google.png'
        ],
        [
            'title' => 'HTML',
            'icon' => 'html.png'
        ],
        [
            'title' => 'Java',
            'icon' => 'java.png'
        ],
        [
            'title' => 'JavaScript',
            'icon' => 'javascript.jpeg'
        ],
        [
            'title' => 'Laravel',
            'icon' => 'laravel.png'
        ],
        [
            'title' => 'Linux',
            'icon' => 'linux.png'
        ],
        [
            'title' => 'Node.js',
            'icon' => 'node-js.png'
        ],
        [
            'title' => 'Open Source',
            'icon' => 'open-source.png'
        ],
        [
            'title' => 'Операционные системы',
            'icon' => 'os.png'
        ],
        [
            'title' => 'PHP',
            'icon' => 'php.png'
        ],
        [
            'title' => 'Python',
            'icon' => 'python.png'
        ],
        [
            'title' => 'SQL',
            'icon' => 'sql.png'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $allTags = [];
        foreach ($this->tags as $tag) {
            $allTags[] = [
                'title' => $tag['title'],
                'slug' => Str::slug($tag['title']),
                'description' => $faker->paragraph(),
                'icon' => 'img/tags/' . $tag['icon']
            ];
        }
        Tag::insert($allTags);
    }
}
