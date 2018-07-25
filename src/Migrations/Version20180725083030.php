<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725083030 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_draft (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_images (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD file_image_id INT DEFAULT NULL, ADD file_draft_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A8CF5AAF0 FOREIGN KEY (file_image_id) REFERENCES product_images (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A53A34A4C FOREIGN KEY (file_draft_id) REFERENCES product_draft (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A8CF5AAF0 ON products (file_image_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A53A34A4C ON products (file_draft_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A53A34A4C');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A8CF5AAF0');
        $this->addSql('DROP TABLE product_draft');
        $this->addSql('DROP TABLE product_images');
        $this->addSql('DROP INDEX UNIQ_B3BA5A5A8CF5AAF0 ON products');
        $this->addSql('DROP INDEX UNIQ_B3BA5A5A53A34A4C ON products');
        $this->addSql('ALTER TABLE products DROP file_image_id, DROP file_draft_id');
    }
}
