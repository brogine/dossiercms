<?php

use yii\db\Migration;

class m160227_221733_init extends Migration
{
    public function up()
    {
        // Posts
        $this->createTable('posts', [
            'id'                => $this->primaryKey(),
            'headline'          => $this->string(255)->notNull(),       // titulo
            'kicker'            => $this->string(50)->notNull(),        // volanta
            'billboard'         => $this->text(),                       // bajada
            'content'           => $this->text()->notNull(),            // cuerpo
            'author_id'         => $this->integer()->notNull(),
            'created'           => $this->timestamp()->notNull(),
            'publish'           => $this->timestamp(),
            'status'            => $this->smallInteger(1)->notNull(),
            'comment_status'    => $this->smallInteger(1)->notNull(),
            'parent'            => $this->integer(),
            'category_id'       => $this->integer(),
            'version'           => $this->integer(),
            'tags'              => $this->text()
        ]);
        
        $this->createIndex('idx-posts-author', 'posts', 'author_id');
        $this->addForeignKey('fk-posts-user', 'posts', 'author_id', 'user', 'id', 'CASCADE', 'RESTRICT');
        
        $this->createIndex('idx-posts-parent', 'posts', 'parent');
        $this->addForeignKey('fk-posts-parent', 'posts', 'parent', 'posts', 'id');
        
        // Post-meta
        $this->createTable('post_meta', [
            'id'                => $this->primaryKey(),
            'post_id'           => $this->integer()->notNull(),
            'meta_key'          => $this->string(255)->notNull(),
            'meta_value'        => $this->text()->notNull()
        ]);
        
        $this->createIndex('idx-post_meta-post_id', 'post_meta', 'post_id');
        $this->addForeignKey('fk-post_meta-posts', 'post_meta', 'post_id', 'posts', 'id', 'CASCADE', 'RESTRICT');
        
        // Post-related
        $this->createTable('post_related', [
            'post_id'           => $this->integer()->notNull(),
            'post_related'      => $this->integer()->notNull(),
            'order'             => $this->smallInteger(2)
        ]);
        
        $this->createIndex('idx-post_related-post_id', 'post_related', 'post_id');
        $this->createIndex('idx-post_related-post_related', 'post_related', 'post_related');

        $this->addForeignKey('fk-post_related-post_id', 'post_related', 'post_id', 'posts', 'id', 'CASCADE');
        $this->addForeignKey('fk-post_related-post_related', 'post_related', 'post_related', 'posts', 'id', 'CASCADE');
        
        // Categories
        $this->createTable('categories', [
            'id'                => $this->primaryKey(),
            'description'       => $this->string(255)->notNull()
        ]);
        
        $this->createIndex('idx-posts-category', 'posts', 'category_id');
        $this->addForeignKey('fk-posts-categories', 'posts', 'category_id', 'categories', 'id', 'CASCADE', 'RESTRICT');
        
        // Tags
        $this->createTable('tags', [
            'id'                => $this->string(100),
            'count'             => $this->integer()->defaultValue(0),
            'PRIMARY KEY(id)'
        ]);
        
        // Post-Tags
        $this->createTable('post_tag', [
            'post_id'           => $this->integer(),
            'tag_id'            => $this->string(100),
            'order'             => $this->smallInteger(2),
            'PRIMARY KEY(post_id, tag_id)'
        ]);
        
        $this->createIndex('idx-post_tag-post_id', 'post_tag', 'post_id');
        $this->createIndex('idx-post_tag-tag_id', 'post_tag', 'tag_id');

        $this->addForeignKey('fk-post_tag-post_id', 'post_tag', 'post_id', 'posts', 'id', 'CASCADE');
        $this->addForeignKey('fk-post_tag-tag_id', 'post_tag', 'tag_id', 'tags', 'id', 'CASCADE');
        
        // Comments
        $this->createTable('comments', [
            'id'                => $this->primaryKey(),
            'model_class'       => $this->string(100)->notNull(),
            'model_pk'          => $this->integer()->notNull(),
            'author_id'         => $this->integer()->notNull(),
            'created'           => $this->timestamp()->notNull(),
            'content'           => $this->text()->notNull(),
            'approved'          => $this->smallInteger(1),
            'parent_id'         => $this->integer()
        ]);
        
        $this->createIndex('idx-comments-parent', 'comments', 'parent_id');
        $this->addForeignKey('fk-comments-parent', 'comments', 'parent_id', 'comments', 'id', 'CASCADE', 'RESTRICT');
        
        // Comments-meta
        $this->createTable('comments_meta', [
            'id'                => $this->primaryKey(),
            'comment_id'        => $this->integer()->notNull(),
            'meta_key'          => $this->string(255)->notNull(),
            'meta_value'        => $this->text()->notNull()
        ]);
        
        $this->createIndex('idx-comments_meta-comment_id', 'comments_meta', 'comment_id');
        $this->addForeignKey('fk-comments_meta-posts', 'comments_meta', 'comment_id', 'comments', 'id', 'CASCADE', 'RESTRICT');
                
        // Polls
        $this->createTable('polls', [
            'id'                => $this->primaryKey(),
            'title'             => $this->string(255)->notNull(),
            'description'       => $this->text(),
            'date_from'         => $this->timestamp(),
            'date_to'           => $this->timestamp(),
            'status'            => $this->smallInteger(1)
        ]);
        
        // Polls_Options    
        $this->createTable('poll_options', [
            'id'                => $this->primaryKey(),
            'poll_id'           => $this->integer()->notNull(),
            'option'            => $this->string(255)->notNull(),
            'votes'             => $this->integer()->defaultValue(0),
            'order'             => $this->smallInteger(2)
        ]);
        
        $this->createIndex('idx-poll_options-poll_id', 'poll_options', 'poll_id');
        $this->addForeignKey('fk-poll_options-poll_id', 'poll_options', 'poll_id', 'polls', 'id', 'CASCADE', 'RESTRICT');
        
        // Polls_Log
        $this->createTable('polls_log', [
            'poll_id'           => $this->integer()->notNull(),
            'poll_option_id'    => $this->integer()->notNull(),
            'user_id'           => $this->integer()->notNull(),
            'ip'                => $this->string(40),
            'date'              => $this->timestamp()
        ]);
        
        $this->createIndex('idx-polls_log-poll_id', 'polls_log', 'poll_id');
        $this->createIndex('idx-polls_log-poll_option_id', 'polls_log', 'poll_option_id');
        $this->createIndex('idx-polls_log-user_id', 'polls_log', 'user_id');
        
        $this->addForeignKey('fk-polls_log-poll_id', 'polls_log', 'poll_id', 'polls', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-polls_log-poll_option_id', 'polls_log', 'poll_option_id', 'poll_options', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-polls_log-user_id', 'polls_log', 'user_id', 'user', 'id', 'CASCADE', 'RESTRICT');
        
        // Multimedia
        $this->createTable('multimedia', [
            'id'                => $this->primaryKey(),
            'category_id'       => $this->integer(),
            'mime'              => $this->string(50)->notNull(),
            'location'          => $this->string(255),
            'description'       => $this->string(255),
            'credits'           => $this->string(255),
            'row'               => $this->smallInteger(2),
            'column'            => $this->smallInteger(2),
            'tags'              => $this->text()
        ]);
        
        $this->createIndex('idx-multimedia-category_id', 'multimedia', 'category_id');
        $this->addForeignKey('fk-multimedia-category_id', 'multimedia', 'category_id', 'categories', 'id', 'CASCADE', 'RESTRICT');
        
        // Multimedia_Tags
        $this->createTable('multimedia_tag', [
            'multimedia_id'     => $this->integer(),
            'tag_id'            => $this->string(100),
            'order'             => $this->smallInteger(2),
            'PRIMARY KEY(multimedia_id, tag_id)'
        ]);
        
        $this->createIndex('idx-multimedia_tag-multimedia_id', 'multimedia_tag', 'multimedia_id');
        $this->createIndex('idx-multimedia_tag-tag_id', 'multimedia_tag', 'tag_id');

        $this->addForeignKey('fk-multimedia_tag-multimedia_id', 'multimedia_tag', 'multimedia_id', 'multimedia', 'id', 'CASCADE');
        $this->addForeignKey('fk-multimedia_tag-tag_id', 'multimedia_tag', 'tag_id', 'tags', 'id', 'CASCADE');
        
        // Post_Multimedia
        $this->createTable('post_multimedia', [
            'post_id'           => $this->integer(),
            'multimedia_id'     => $this->integer(),
            'description'       => $this->text(),
            'mime'              => $this->string(50)->notNull(),
            'order'             => $this->smallInteger(2),
            'PRIMARY KEY(post_id, multimedia_id)'
        ]);
        
        $this->createIndex('idx-post_multimedia-post_id', 'post_multimedia', 'post_id');
        $this->createIndex('idx-post_multimedia-multimedia_id', 'post_multimedia', 'multimedia_id');

        $this->addForeignKey('fk-post_multimedia-post_id', 'post_multimedia', 'post_id', 'posts', 'id', 'CASCADE');
        $this->addForeignKey('fk-post_multimedia-multimedia_id', 'post_multimedia', 'multimedia_id', 'multimedia', 'id', 'CASCADE');

    }

    public function down()
    {
        echo "m160227_221733_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
