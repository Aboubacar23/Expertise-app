<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613084511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_fonctionnement CHANGE t t DOUBLE PRECISION DEFAULT NULL, CHANGE u u VARCHAR(255) DEFAULT NULL, CHANGE i1 i1 VARCHAR(255) DEFAULT NULL, CHANGE i2 i2 VARCHAR(255) DEFAULT NULL, CHANGE i3 i3 VARCHAR(255) DEFAULT NULL, CHANGE p p VARCHAR(255) DEFAULT NULL, CHANGE q q VARCHAR(255) DEFAULT NULL, CHANGE cos cos VARCHAR(255) DEFAULT NULL, CHANGE n n VARCHAR(255) DEFAULT NULL, CHANGE i i VARCHAR(255) DEFAULT NULL, CHANGE tamb tamb VARCHAR(255) DEFAULT NULL, CHANGE ca ca VARCHAR(255) DEFAULT NULL, CHANGE coa coa VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_fonctionnement CHANGE t t VARCHAR(255) DEFAULT NULL, CHANGE u u DOUBLE PRECISION DEFAULT NULL, CHANGE i1 i1 DOUBLE PRECISION DEFAULT NULL, CHANGE i2 i2 DOUBLE PRECISION DEFAULT NULL, CHANGE i3 i3 DOUBLE PRECISION DEFAULT NULL, CHANGE p p DOUBLE PRECISION DEFAULT NULL, CHANGE q q DOUBLE PRECISION DEFAULT NULL, CHANGE cos cos DOUBLE PRECISION DEFAULT NULL, CHANGE n n DOUBLE PRECISION DEFAULT NULL, CHANGE i i DOUBLE PRECISION DEFAULT NULL, CHANGE tamb tamb DOUBLE PRECISION DEFAULT NULL, CHANGE ca ca DOUBLE PRECISION DEFAULT NULL, CHANGE coa coa DOUBLE PRECISION DEFAULT NULL');
    }
}
