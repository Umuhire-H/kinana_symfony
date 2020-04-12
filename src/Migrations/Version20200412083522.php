<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412083522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, place INT NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_execution (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, date DATETIME NOT NULL, free_place INT NOT NULL, is_complete TINYINT(1) NOT NULL, INDEX IDX_E5B8F08D81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, date_birth DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child_user (child_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_38A275BBDD62C21B (child_id), INDEX IDX_38A275BBA76ED395 (user_id), PRIMARY KEY(child_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, activity_execution_id INT NOT NULL, user_id INT DEFAULT NULL, child_id INT DEFAULT NULL, date_payement DATETIME DEFAULT NULL, price_payed NUMERIC(10, 2) DEFAULT NULL, type_payement VARCHAR(50) NOT NULL, status_payement VARCHAR(50) NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_AB55E24F5EAA9705 (activity_execution_id), INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24FDD62C21B (child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE text (id INT AUTO_INCREMENT NOT NULL, user_requester_id INT DEFAULT NULL, user_translator_id INT NOT NULL, name VARCHAR(255) NOT NULL, content_to_translate LONGTEXT NOT NULL, content_translated LONGTEXT DEFAULT NULL, date_reception DATETIME NOT NULL, date_return DATETIME DEFAULT NULL, rating INT DEFAULT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_3B8BA7C76D8850F6 (user_requester_id), INDEX IDX_3B8BA7C7BDFE495B (user_translator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, activity_execution_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, date_birth DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6495EAA9705 (activity_execution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_execution ADD CONSTRAINT FK_E5B8F08D81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE child_user ADD CONSTRAINT FK_38A275BBDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child_user ADD CONSTRAINT FK_38A275BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F5EAA9705 FOREIGN KEY (activity_execution_id) REFERENCES activity_execution (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C76D8850F6 FOREIGN KEY (user_requester_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE text ADD CONSTRAINT FK_3B8BA7C7BDFE495B FOREIGN KEY (user_translator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495EAA9705 FOREIGN KEY (activity_execution_id) REFERENCES activity_execution (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_execution DROP FOREIGN KEY FK_E5B8F08D81C06096');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F5EAA9705');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495EAA9705');
        $this->addSql('ALTER TABLE child_user DROP FOREIGN KEY FK_38A275BBDD62C21B');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FDD62C21B');
        $this->addSql('ALTER TABLE child_user DROP FOREIGN KEY FK_38A275BBA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C76D8850F6');
        $this->addSql('ALTER TABLE text DROP FOREIGN KEY FK_3B8BA7C7BDFE495B');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_execution');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE child_user');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE text');
        $this->addSql('DROP TABLE user');
    }
}
