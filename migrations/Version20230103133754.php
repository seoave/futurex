<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230103133754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE currencies_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE orders_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE currency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE currency (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, user_id INT NOT NULL, date INT NOT NULL, currency_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, order_type VARCHAR(7) NOT NULL, rate DOUBLE PRECISION NOT NULL, stock DOUBLE PRECISION NOT NULL, offer_type VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, acceptor_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, date INT NOT NULL, offer_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, gender SMALLINT DEFAULT NULL, birthday INT NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, language VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE offers');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE currency_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE order_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE currencies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE orders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(30) DEFAULT NULL, gender SMALLINT DEFAULT NULL, birthday INT NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, language VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE currencies (id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE orders (id INT NOT NULL, acceptor_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, date INT NOT NULL, offer_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE offers (id INT NOT NULL, user_id INT NOT NULL, date INT NOT NULL, currency_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, order_type VARCHAR(7) NOT NULL, rate DOUBLE PRECISION NOT NULL, stock DOUBLE PRECISION NOT NULL, offer_type VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE "user"');
    }
}
