<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705074515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contre_expertise (id INT AUTO_INCREMENT NOT NULL, recapitulatif LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parametre ADD contre_expertise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parametre ADD CONSTRAINT FK_ACC790415420D56F FOREIGN KEY (contre_expertise_id) REFERENCES contre_expertise (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACC790415420D56F ON parametre (contre_expertise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parametre DROP FOREIGN KEY FK_ACC790415420D56F');
        $this->addSql('DROP TABLE contre_expertise');
        $this->addSql('DROP INDEX UNIQ_ACC790415420D56F ON parametre');
        $this->addSql('ALTER TABLE parametre DROP contre_expertise_id');
    }
}
