<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620071141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stator_apres_lavage DROP valeur1, DROP valeur2, DROP valeur3, DROP valeur4, DROP valeur5, DROP valeur6, DROP valeur7, DROP conformite1, DROP conformite2, DROP conformite3, DROP conformite4, DROP conformite5, DROP conformite6, DROP conformite7');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stator_apres_lavage ADD valeur1 DOUBLE PRECISION NOT NULL, ADD valeur2 DOUBLE PRECISION NOT NULL, ADD valeur3 DOUBLE PRECISION NOT NULL, ADD valeur4 DOUBLE PRECISION NOT NULL, ADD valeur5 DOUBLE PRECISION NOT NULL, ADD valeur6 DOUBLE PRECISION NOT NULL, ADD valeur7 DOUBLE PRECISION NOT NULL, ADD conformite1 VARCHAR(255) NOT NULL, ADD conformite2 VARCHAR(255) NOT NULL, ADD conformite3 VARCHAR(255) NOT NULL, ADD conformite4 VARCHAR(255) NOT NULL, ADD conformite5 VARCHAR(255) NOT NULL, ADD conformite6 VARCHAR(255) NOT NULL, ADD conformite7 VARCHAR(255) NOT NULL');
    }
}
