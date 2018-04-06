<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180329074649 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum MODIFY category text');

        $this->addSql('UPDATE categories SET parent_id = null WHERE parent_id = 0');
        $this->addSql('ALTER TABLE categories CHANGE add_date create_date date');
        $this->addSql('ALTER TABLE categories CHANGE add_date create_date date');
        $this->addSql('UPDATE categories SET path = \'nabor-uplotnitelej-dlja-porshnja-nbr-cpom\', full_path = \'uplotnenija-i-uplotnitelnye-kolca/porshnevye-uplotnenija/nabor-uplotnitelej-dlja-porshnja-nbr-cpom\' WHERE id = 1456');

        $this->addSql('DROP INDEX category_id ON products');
        $this->addSql('DROP INDEX `order` ON products');
        $this->addSql('DROP INDEX product_id ON products');
        $this->addSql('DROP INDEX s_name ON products');
        $this->addSql('DROP INDEX sku ON products');
        $this->addSql('ALTER TABLE products ENGINE = innoDB');
        $this->addSql('UPDATE products SET name = sku WHERE name is null');
        $this->addSql('ALTER TABLE products CHANGE add_date create_date date');
        $this->addSql('ALTER TABLE products CHANGE mod_date update_date date');
        $this->addSql('ALTER TABLE products CHANGE category_id category_idx int(11)');
        $this->addSql('DELETE FROM products WHERE id = 1714 AND path = \'ASRS-30-100-PP\'');
        $this->addSql('UPDATE products SET path = \'AT-M\' WHERE id = 8342');
        $this->addSql('UPDATE products SET path = \'ADS-M\' WHERE id = 49540');
        $this->addSql('UPDATE products SET path = \'AW-VA\' WHERE id = 10356');

        $this->addSql('ALTER TABLE products_params CHANGE `order` sorting int(11)');

        $this->addSql('ALTER TABLE manufacture CHANGE title name varchar(255) NOT NULL');
        $this->addSql('ALTER TABLE manufacture_categories CHANGE title name varchar(255) NOT NULL');

        $this->addSql('ALTER TABLE pages CHANGE title name varchar(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
