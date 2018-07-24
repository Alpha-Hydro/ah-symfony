<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * DROP MANY TO MANY USER USER_ROLES
 */
final class Version20180724133101 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_roles_user');
        $this->addSql('ALTER TABLE users_app ADD user_roles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users_app ADD CONSTRAINT FK_FAB5E7F9D84AB5C4 FOREIGN KEY (user_roles_id) REFERENCES user_roles (id)');
        $this->addSql('CREATE INDEX IDX_FAB5E7F9D84AB5C4 ON users_app (user_roles_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_roles_user (user_roles_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F0634DDCD84AB5C4 (user_roles_id), INDEX IDX_F0634DDCA76ED395 (user_id), PRIMARY KEY(user_roles_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_roles_user ADD CONSTRAINT FK_F0634DDCA76ED395 FOREIGN KEY (user_id) REFERENCES users_app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_roles_user ADD CONSTRAINT FK_F0634DDCD84AB5C4 FOREIGN KEY (user_roles_id) REFERENCES user_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_app DROP FOREIGN KEY FK_FAB5E7F9D84AB5C4');
        $this->addSql('DROP INDEX IDX_FAB5E7F9D84AB5C4 ON users_app');
        $this->addSql('ALTER TABLE users_app DROP user_roles_id');
    }
}
