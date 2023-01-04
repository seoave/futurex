<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104224052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT fk_7c68921f28a69c31');
        $this->addSql('DROP INDEX idx_7c68921f28a69c31');
        $this->addSql('ALTER TABLE wallet DROP currency_id');
        $this->addSql('ALTER TABLE wallet DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE wallet ADD currency_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT fk_7c68921f28a69c31 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7c68921f28a69c31 ON wallet (currency_id)');
    }
}
