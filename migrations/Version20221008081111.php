<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221008081111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'created cocktail and category entity (PROJ-14)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cocktail (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, ingredients LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', stars INT NOT NULL, prepare_time INT NOT NULL, difficulty VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_7B4914D412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cocktail ADD CONSTRAINT FK_7B4914D412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cocktail DROP FOREIGN KEY FK_7B4914D412469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE cocktail');
    }
}
