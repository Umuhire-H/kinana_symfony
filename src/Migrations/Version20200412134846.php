<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412134846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_activity_execution (user_id INT NOT NULL, activity_execution_id INT NOT NULL, INDEX IDX_49FC1676A76ED395 (user_id), INDEX IDX_49FC16765EAA9705 (activity_execution_id), PRIMARY KEY(user_id, activity_execution_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_activity_execution ADD CONSTRAINT FK_49FC1676A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_activity_execution ADD CONSTRAINT FK_49FC16765EAA9705 FOREIGN KEY (activity_execution_id) REFERENCES activity_execution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495EAA9705');
        $this->addSql('DROP INDEX IDX_8D93D6495EAA9705 ON user');
        $this->addSql('ALTER TABLE user DROP activity_execution_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_activity_execution');
        $this->addSql('ALTER TABLE user ADD activity_execution_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495EAA9705 FOREIGN KEY (activity_execution_id) REFERENCES activity_execution (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495EAA9705 ON user (activity_execution_id)');
    }
}
