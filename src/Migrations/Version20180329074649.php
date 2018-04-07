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

        //Forum
        $this->addSql('ALTER TABLE forum MODIFY category text');

        //Categories
        $this->addSql('UPDATE categories SET parent_id = null WHERE parent_id = 0');
        $this->addSql('UPDATE categories SET add_date = now() where add_date is null');
        $this->addSql('UPDATE categories SET mod_date = now() where mod_date is null');
        $this->addSql('ALTER TABLE categories CHANGE add_date create_date date');
        $this->addSql('ALTER TABLE categories CHANGE mod_date update_date date');
        $this->addSql('UPDATE categories SET path = \'nabor-uplotnitelej-dlja-porshnja-nbr-cpom\', full_path = \'uplotnenija-i-uplotnitelnye-kolca/porshnevye-uplotnenija/nabor-uplotnitelej-dlja-porshnja-nbr-cpom\' WHERE id = 1456');

        //Products
        $this->addSql('ALTER TABLE products MODIFY id int(11) NOT NULL auto_increment');
        $this->addSql('DROP INDEX category_id ON products');
        $this->addSql('DROP INDEX `order` ON products');
        $this->addSql('DROP INDEX product_id ON products');
        $this->addSql('DROP INDEX s_name ON products');
        $this->addSql('DROP INDEX sku ON products');
        $this->addSql('ALTER TABLE products ENGINE = innoDB');
        $this->addSql('UPDATE products SET name = sku WHERE name is null');
        $this->addSql('ALTER TABLE products CHANGE add_date create_date date');
        $this->addSql('ALTER TABLE products CHANGE mod_date update_date date');
        $this->addSql('UPDATE products SET create_date = now() where create_date is null');
        $this->addSql('UPDATE products SET update_date = now() where update_date is null');

//        $this->addSql('ALTER TABLE products CHANGE category_id category_idx int(11)');
        $this->addSql('UPDATE products SET path = \'ASRS30-100PP\' WHERE id = 1714');
        $this->addSql('UPDATE products SET path = \'AT-M\' WHERE id = 8342');
        $this->addSql('UPDATE products SET path = \'ADS-M\' WHERE id = 49540');
        $this->addSql('UPDATE products SET path = \'AW-VA\' WHERE id = 10356');

        //ProductParams
        $this->addSql('DROP INDEX `order` ON product_params');
        $this->addSql('DROP INDEX product_id ON product_params');
        $this->addSql('ALTER TABLE product_params CHANGE `order` sorting int(11)');

        //Manufacture
        $this->addSql('ALTER TABLE manufacture CHANGE title name varchar(255) NOT NULL');

        //ManufactureCategories
        $this->addSql('ALTER TABLE manufacture_categories CHANGE title name varchar(255) NOT NULL');
        $this->addSql('ALTER TABLE manufacture_categories ADD full_path varchar(255) NULL');
        $this->addSql('UPDATE manufacture_categories SET full_path = path');

        //Pages
        $this->addSql('ALTER TABLE pages CHANGE title name varchar(255) NOT NULL');
        $this->addSql('ALTER TABLE pages ADD full_path varchar(255) NULL');
        $this->addSql('UPDATE pages SET full_path = path');

        //Media
        $this->addSql('UPDATE media SET category_id = NULL WHERE category_id = 5');
        $this->addSql('UPDATE media SET category_id = NULL WHERE category_id = 7');

        //MediaCategories
        $this->addSql('DROP INDEX unique_id ON media_categories');
        $this->addSql('ALTER TABLE media_categories MODIFY id int(11) NOT NULL auto_increment');
        $this->addSql('ALTER TABLE media_categories MODIFY parent_id int(11)');
        $this->addSql('ALTER TABLE media_categories ADD full_path varchar(255) NULL');
        $this->addSql('UPDATE media_categories SET path = \'archive\' WHERE path IS NULL OR path=\'\'');
        $this->addSql('UPDATE media_categories SET full_path = path');
        $this->addSql(' DELETE FROM media_categories WHERE id = 1');
        $this->addSql(' DELETE FROM media_categories WHERE id = 5');
        $this->addSql(' DELETE FROM media_categories WHERE id = 6');
        $this->addSql(' DELETE FROM media_categories WHERE id = 7');
        $this->addSql(' DELETE FROM media_categories WHERE id = 8');

        //wf_product
        $this->addSql('ALTER TABLE wf_product DROP FOREIGN KEY fk_product_product_construction1, DROP FOREIGN KEY fk_product_product_size1, DROP FOREIGN KEY fk_product_product_type1, DROP FOREIGN KEY fk_product_product_control1');
        $this->addSql('ALTER TABLE wf_product ADD create_date date, ADD update_date date');
        $this->addSql('UPDATE wf_product SET create_date = now(), update_date = now()');
        $this->addSql('UPDATE wf_product SET name = data_sheet_no');


        //wf_category
        $this->addSql('ALTER TABLE wf_category ADD create_date date, ADD update_date date');
        $this->addSql('UPDATE wf_category SET create_date = now(), update_date = now()');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
