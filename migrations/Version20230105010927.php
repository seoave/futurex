<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105010927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, user_id INT NOT NULL, currency_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount DOUBLE PRECISION NOT NULL, order_type VARCHAR(10) NOT NULL, rate DOUBLE PRECISION NOT NULL, stock DOUBLE PRECISION NOT NULL, offer_type VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29D6873E9D86650F ON offer (user_id)');
        $this->addSql('CREATE INDEX IDX_29D6873E28A69C31 ON offer (currency_id)');
        $this->addSql('COMMENT ON COLUMN offer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E9D86650F FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E28A69C31 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873E9D86650F');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873E28A69C31');
        $this->addSql('DROP TABLE offer');
    }
}
