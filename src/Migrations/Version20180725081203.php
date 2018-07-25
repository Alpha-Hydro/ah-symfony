<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725081203 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category_images (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories ADD new_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346687ACCA941 FOREIGN KEY (new_image_id) REFERENCES category_images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF346687ACCA941 ON categories (new_image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346687ACCA941');
        $this->addSql('DROP TABLE category_images');
        $this->addSql('DROP INDEX UNIQ_3AF346687ACCA941 ON categories');
        $this->addSql('ALTER TABLE categories DROP new_image_id');
    }
}
