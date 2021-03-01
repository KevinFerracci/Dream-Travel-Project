<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301092239 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD review_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F893E2E969B ON picture (review_id)');
        $this->addSql('ALTER TABLE review ADD city_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD is_reported TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_794381C68BAC62AF ON review (city_id)');
        $this->addSql('CREATE INDEX IDX_794381C6A76ED395 ON review (user_id)');
        $this->addSql('ALTER TABLE weather CHANGE month month INT NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE year year INT NOT NULL, CHANGE average_min average_min INT NOT NULL, CHANGE average_max average_max INT NOT NULL, CHANGE temp_level_min temp_level_min INT NOT NULL, CHANGE temp_level_max temp_level_max INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893E2E969B');
        $this->addSql('DROP INDEX IDX_16DB4F893E2E969B ON picture');
        $this->addSql('ALTER TABLE picture DROP review_id');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68BAC62AF');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('DROP INDEX IDX_794381C68BAC62AF ON review');
        $this->addSql('DROP INDEX IDX_794381C6A76ED395 ON review');
        $this->addSql('ALTER TABLE review DROP city_id, DROP user_id, DROP is_reported');
        $this->addSql('ALTER TABLE weather CHANGE month month VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE year year VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE average_min average_min VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE average_max average_max VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE temp_level_min temp_level_min VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE temp_level_max temp_level_max VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
