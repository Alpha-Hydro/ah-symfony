<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180712135555 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_app DROP FOREIGN KEY FK_8D93D649B8C2FD88');
        $this->addSql('CREATE TABLE user_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles_user (user_roles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F0634DDCD84AB5C4 (user_roles_id), INDEX IDX_F0634DDCA76ED395 (user_id), PRIMARY KEY(user_roles_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_roles_user ADD CONSTRAINT FK_F0634DDCD84AB5C4 FOREIGN KEY (user_roles_id) REFERENCES user_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_roles_user ADD CONSTRAINT FK_F0634DDCA76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE categories_xref');
        $this->addSql('DROP TABLE categoryindex');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE oil');
        $this->addSql('DROP TABLE oil_categories');
        $this->addSql('DROP TABLE pipeline');
        $this->addSql('DROP TABLE pipeline_categories');
        $this->addSql('DROP TABLE pipeline_property');
        $this->addSql('DROP TABLE pipeline_property_values');
        $this->addSql('DROP TABLE productindex');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users_app');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_roles_user DROP FOREIGN KEY FK_F0634DDCD84AB5C4');
        $this->addSql('CREATE TABLE categories_xref (product_id BIGINT NOT NULL, category_id BIGINT NOT NULL, PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoryindex (id BIGINT AUTO_INCREMENT NOT NULL, category_id BIGINT NOT NULL, page BIGINT NOT NULL, depth TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id BIGINT AUTO_INCREMENT NOT NULL, parent_id BIGINT DEFAULT NULL, category TEXT DEFAULT NULL COLLATE utf8_general_ci, author VARCHAR(255) NOT NULL COLLATE utf8_general_ci, email VARCHAR(255) NOT NULL COLLATE utf8_general_ci, content LONGTEXT NOT NULL COLLATE utf8_general_ci, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, active INT DEFAULT 1 NOT NULL, deleted INT DEFAULT 0 NOT NULL, content_markdown LONGTEXT DEFAULT NULL COLLATE utf8_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oil (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT 0 NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, path VARCHAR(128) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(128) DEFAULT NULL COLLATE utf8_general_ci, date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active TINYINT(1) DEFAULT \'1\' NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted TINYINT(1) DEFAULT \'0\' NOT NULL, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, UNIQUE INDEX unique_id (id), UNIQUE INDEX oil_full_path_uindex (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oil_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT 0 NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, create_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active INT DEFAULT 1 NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, UNIQUE INDEX oil_categories_id_uindex (id), UNIQUE INDEX oil_categories_full_path_uindex (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT 0 NOT NULL, path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, create_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active INT DEFAULT 1 NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, image_draft VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, image_table VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, gost_name VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, UNIQUE INDEX unique_id (id), UNIQUE INDEX unique_full_path (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT 0 NOT NULL, path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, create_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active INT DEFAULT 1 NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, UNIQUE INDEX unique_id (id), UNIQUE INDEX unique_full_path (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline_property (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, sorting INT DEFAULT 0 NOT NULL, show_list INT DEFAULT 1 NOT NULL, active INT DEFAULT 1 NOT NULL, deleted INT DEFAULT 0 NOT NULL, sistem_name VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, type INT DEFAULT 0 NOT NULL, UNIQUE INDEX unique_id (id), UNIQUE INDEX unique_sistem_name (sistem_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline_property_values (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, pipeline_id INT NOT NULL, value TEXT DEFAULT NULL COLLATE utf8_general_ci, INDEX property_id (property_id), INDEX pipeline_id (pipeline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productindex (id BIGINT AUTO_INCREMENT NOT NULL, product_id BIGINT NOT NULL, page INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(42) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_app (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(42) DEFAULT NULL COLLATE utf8_unicode_ci, email VARCHAR(42) NOT NULL COLLATE utf8_unicode_ci, phone VARCHAR(42) DEFAULT NULL COLLATE utf8_unicode_ci, address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, roleId INT NOT NULL, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, status INT NOT NULL, dateCreate DATETIME NOT NULL, pwdResetToken VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, pwdResetTokenCreateDate DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649B8C2FD88 (roleId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_app ADD CONSTRAINT FK_8D93D649B8C2FD88 FOREIGN KEY (roleId) REFERENCES roles (id)');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('DROP TABLE user_roles_user');
    }
}
