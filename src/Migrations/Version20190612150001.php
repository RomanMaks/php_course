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

        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('
CREATE TABLE "user" (
  id INT NOT NULL,
  password TEXT,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR (100) NOT NULL,
  middle_name VARCHAR (100),
  phone VARCHAR(11) NOT NULL,
  email VARCHAR(100) NOT NULL,
  created_at TIMESTAMP NOT NULL current_timestamp(),
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  PRIMARY KEY(id)
  )
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP TABLE "user"');
    }
}
