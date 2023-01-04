<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104224408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD currency_id INT NOT NULL');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F9D86650F FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F28A69C31 FOREIGN KEY (currency_id) REFERENCES currency (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C68921F9D86650F ON wallet (user_id)');
        $this->addSql('CREATE INDEX IDX_7C68921F28A69C31 ON wallet (currency_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F9D86650F');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F28A69C31');
        $this->addSql('DROP INDEX IDX_7C68921F9D86650F');
        $this->addSql('DROP INDEX IDX_7C68921F28A69C31');
        $this->addSql('ALTER TABLE wallet DROP user_id');
        $this->addSql('ALTER TABLE wallet DROP currency_id');
    }
}
