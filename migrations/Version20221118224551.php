<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221118224551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'added user table (PROJ-22)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_cocktail (user_id INT NOT NULL, cocktail_id INT NOT NULL, INDEX IDX_9BC4F0D4A76ED395 (user_id), INDEX IDX_9BC4F0D4CD6F76C6 (cocktail_id), PRIMARY KEY(user_id, cocktail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_cocktail ADD CONSTRAINT FK_9BC4F0D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_cocktail ADD CONSTRAINT FK_9BC4F0D4CD6F76C6 FOREIGN KEY (cocktail_id) REFERENCES cocktail (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_cocktail DROP FOREIGN KEY FK_9BC4F0D4A76ED395');
        $this->addSql('ALTER TABLE user_cocktail DROP FOREIGN KEY FK_9BC4F0D4CD6F76C6');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_cocktail');
    }
}
