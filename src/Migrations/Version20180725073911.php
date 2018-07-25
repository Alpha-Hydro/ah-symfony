<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725073911 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws DBALException
     * @throws AbortMigrationException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE oil');
        $this->addSql('DROP TABLE oil_categories');
        $this->addSql('DROP TABLE pipeline');
        $this->addSql('DROP TABLE pipeline_categories');
        $this->addSql('DROP TABLE pipeline_property');
        $this->addSql('DROP TABLE pipeline_property_values');
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     * @throws AbortMigrationException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE forum (id BIGINT AUTO_INCREMENT NOT NULL, parent_id BIGINT DEFAULT NULL, category TEXT DEFAULT NULL COLLATE utf8_general_ci, author VARCHAR(255) NOT NULL COLLATE utf8_general_ci, email VARCHAR(255) NOT NULL COLLATE utf8_general_ci, content LONGTEXT NOT NULL COLLATE utf8_general_ci, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, active INT DEFAULT 1 NOT NULL, deleted INT DEFAULT 0 NOT NULL, content_markdown LONGTEXT DEFAULT NULL COLLATE utf8_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oil (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT 0 NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, path VARCHAR(128) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(128) DEFAULT NULL COLLATE utf8_general_ci, date_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active TINYINT(1) DEFAULT \'1\' NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted TINYINT(1) DEFAULT \'0\' NOT NULL, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, UNIQUE INDEX unique_id (id), UNIQUE INDEX oil_full_path_uindex (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oil_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT 0 NOT NULL, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, create_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active INT DEFAULT 1 NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, UNIQUE INDEX oil_categories_id_uindex (id), UNIQUE INDEX oil_categories_full_path_uindex (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT 0 NOT NULL, path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, create_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active INT DEFAULT 1 NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, image_draft VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, image_table VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, gost_name VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, UNIQUE INDEX unique_id (id), UNIQUE INDEX unique_full_path (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT 0 NOT NULL, path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, full_path VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT DEFAULT NULL COLLATE utf8_general_ci, content_html TEXT DEFAULT NULL COLLATE utf8_general_ci, content_markdown TEXT DEFAULT NULL COLLATE utf8_general_ci, image VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, create_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, meta_description TEXT DEFAULT NULL COLLATE utf8_general_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, active INT DEFAULT 1 NOT NULL, sorting INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, UNIQUE INDEX unique_id (id), UNIQUE INDEX unique_full_path (full_path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline_property (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, sorting INT DEFAULT 0 NOT NULL, show_list INT DEFAULT 1 NOT NULL, active INT DEFAULT 1 NOT NULL, deleted INT DEFAULT 0 NOT NULL, sistem_name VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, type INT DEFAULT 0 NOT NULL, UNIQUE INDEX unique_id (id), UNIQUE INDEX unique_sistem_name (sistem_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pipeline_property_values (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, pipeline_id INT NOT NULL, value TEXT DEFAULT NULL COLLATE utf8_general_ci, INDEX property_id (property_id), INDEX pipeline_id (pipeline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }
}
