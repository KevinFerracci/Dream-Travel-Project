<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309124633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city_list_user (city_list_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6C0915B580E6A8D9 (city_list_id), INDEX IDX_6C0915B5A76ED395 (user_id), PRIMARY KEY(city_list_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city_list_city (city_list_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_CCC1C1C880E6A8D9 (city_list_id), INDEX IDX_CCC1C1C88BAC62AF (city_id), PRIMARY KEY(city_list_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city_list_user ADD CONSTRAINT FK_6C0915B580E6A8D9 FOREIGN KEY (city_list_id) REFERENCES city_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city_list_user ADD CONSTRAINT FK_6C0915B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city_list_city ADD CONSTRAINT FK_CCC1C1C880E6A8D9 FOREIGN KEY (city_list_id) REFERENCES city_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city_list_city ADD CONSTRAINT FK_CCC1C1C88BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE city_list_user');
        $this->addSql('DROP TABLE city_list_city');
    }
}
