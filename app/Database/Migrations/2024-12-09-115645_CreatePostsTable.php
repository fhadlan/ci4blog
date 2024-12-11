<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Creates the `posts` table with necessary fields and configurations.
     *
     * This migration sets up the `posts` table with the following fields:
     * - id: An auto-incrementing primary key.
     * - author_id: An integer representing the ID of the author.
     * - category_id: An integer representing the ID of the category.
     * - sub_category_id: An integer representing the ID of the sub-category.
     * - title: A string for the post title.
     * - slug: A string for the URL-friendly version of the title.
     * - image: A string for the image path or URL.
     * - tags: A text field for storing post tags (nullable).
     * - meta_keywords: A text field for meta keywords (nullable).
     * - meta_description: A text field for meta description (nullable).
     * - visibility: An integer to control the visibility status, defaulting to 1.
     * - created_at: Timestamp for when the post was created.
     * - updated_at: Timestamp for the last update, automatically updated.
     */
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'author_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'content' => [
                'type' => 'TEXT'
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tags' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'meta_keywords' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'meta_description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'visibility' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id');
        $this->forge->createTable('posts');
    }

    /**
     * Reverse the migrations by dropping the posts table.
     */
    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
