<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325134433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FC270CED');
        $this->addSql('DROP INDEX IDX_8D93D649FC270CED ON user');
        $this->addSql('ALTER TABLE user CHANGE in_cour_id in_lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF62E535 FOREIGN KEY (in_lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AF62E535 ON user (in_lesson_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF62E535');
        $this->addSql('DROP INDEX IDX_8D93D649AF62E535 ON user');
        $this->addSql('ALTER TABLE user CHANGE in_lesson_id in_cour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FC270CED FOREIGN KEY (in_cour_id) REFERENCES cour (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649FC270CED ON user (in_cour_id)');
    }
}
