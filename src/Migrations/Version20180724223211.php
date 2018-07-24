<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180724223211 extends AbstractMigration
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

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466856BDE140');
        $this->addSql('DROP INDEX UNIQ_3AF3466856BDE140 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE old_image_id old_images_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466891FB4154 FOREIGN KEY (old_images_id) REFERENCES category_images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF3466891FB4154 ON categories (old_images_id)');
        $this->addSql('ALTER TABLE category_images DROP category_id');
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

        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF3466891FB4154');
        $this->addSql('DROP INDEX UNIQ_3AF3466891FB4154 ON categories');
        $this->addSql('ALTER TABLE categories CHANGE old_images_id old_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466856BDE140 FOREIGN KEY (old_image_id) REFERENCES category_images (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF3466856BDE140 ON categories (old_image_id)');
        $this->addSql('ALTER TABLE category_images ADD category_id INT DEFAULT NULL');
    }
}
