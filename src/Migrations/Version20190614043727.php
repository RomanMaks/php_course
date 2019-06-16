<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190614043727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('
CREATE TABLE roles (
  id BIGSERIAL PRIMARY KEY,
  codename VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL
)'
        );
        $this->addSql('CREATE UNIQUE INDEX uniq_roles_codename ON roles (codename)');

        $this->addSql('INSERT INTO roles (codename, title) VALUES (\'ROLE_USER\', \'Пользователь\')');
        $this->addSql('INSERT INTO roles (codename, title) VALUES (\'ROLE_ADMIN\', \'Администратор\')');

        $this->addSql('
CREATE TABLE users_roles (
  user_id BIGINT NOT NULL,
  role_id BIGINT NOT NULL,
  PRIMARY KEY(user_id, role_id)
)'
        );
        $this->addSql('CREATE INDEX idx_users_roles_user_id ON users_roles (user_id)');
        $this->addSql('CREATE INDEX idx_users_roles_role_id ON users_roles (role_id)');

        $this->addSql('
ALTER TABLE users_roles 
ADD CONSTRAINT fk_users_roles_user_id 
FOREIGN KEY (user_id) 
REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
        $this->addSql('
ALTER TABLE users_roles 
ADD CONSTRAINT fk_users_roles_role_id 
FOREIGN KEY (role_id) 
REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('ALTER TABLE user_roles DROP CONSTRAINT fk_user_roles_user_id');
        $this->addSql('ALTER TABLE user_roles DROP CONSTRAINT fk_user_roles_role_id');

        $this->addSql('DROP TABLE user_roles');
        $this->addSql('DROP TABLE roles');
    }
}
