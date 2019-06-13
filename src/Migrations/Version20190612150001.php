<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190612150001 extends AbstractMigration
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

        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('
CREATE TABLE users (
  id INT NOT NULL,
  password TEXT,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR (100) NOT NULL,
  middle_name VARCHAR (100),
  phone VARCHAR(11) NOT NULL,
  email VARCHAR(100) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  PRIMARY KEY(id)
  )
        ');
        $this->addSql('CREATE UNIQUE INDEX uniq_users_email ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX uniq_users_phone ON users (phone)');

        $this->addSql('
CREATE TABLE user_roles (
  user_id INT NOT NULL,
  role_id INT NOT NULL,
  PRIMARY KEY(user_id, role_id)
)'
        );
        $this->addSql('CREATE INDEX idx_user_roles_user_id ON user_roles (user_id)');
        $this->addSql('CREATE INDEX idx_user_roles_role_id ON user_roles (role_id)');

        $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('
CREATE TABLE roles (
  id SERIAL,
  codename VARCHAR(20) NOT NULL,
  title VARCHAR(50) NOT NULL,
  PRIMARY KEY(id)
)'
        );
        $this->addSql('CREATE UNIQUE INDEX uniq_roles_codename ON roles (codename)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT fk_user_roles_user_id FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT fk_user_roles_role_id FOREIGN KEY (role_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('INSERT INTO roles (codename, title) VALUES (\'ROLE_USER\', \'Пользователь\')');
        $this->addSql('INSERT INTO roles (codename, title) VALUES (\'ROLE_ADMIN\', \'Администратор\')');
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
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_id_seq CASCADE');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('DROP TABLE roles');
    }
}
