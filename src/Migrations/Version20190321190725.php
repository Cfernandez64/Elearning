<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321190725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson_content DROP FOREIGN KEY FK_BB9620E394E8343');
        $this->addSql('ALTER TABLE lesson_content DROP FOREIGN KEY FK_BB9620EFED07355');
        $this->addSql('DROP INDEX IDX_BB9620E394E8343 ON lesson_content');
        $this->addSql('DROP INDEX IDX_BB9620EFED07355 ON lesson_content');
        $this->addSql('ALTER TABLE lesson_content ADD lesson_id INT DEFAULT NULL, ADD content_id INT DEFAULT NULL, DROP lessons_id, DROP contents_id');
        $this->addSql('ALTER TABLE lesson_content ADD CONSTRAINT FK_BB9620ECDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE lesson_content ADD CONSTRAINT FK_BB9620E84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('CREATE INDEX IDX_BB9620ECDF80196 ON lesson_content (lesson_id)');
        $this->addSql('CREATE INDEX IDX_BB9620E84A0A3ED ON lesson_content (content_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lesson_content DROP FOREIGN KEY FK_BB9620ECDF80196');
        $this->addSql('ALTER TABLE lesson_content DROP FOREIGN KEY FK_BB9620E84A0A3ED');
        $this->addSql('DROP INDEX IDX_BB9620ECDF80196 ON lesson_content');
        $this->addSql('DROP INDEX IDX_BB9620E84A0A3ED ON lesson_content');
        $this->addSql('ALTER TABLE lesson_content ADD lessons_id INT DEFAULT NULL, ADD contents_id INT DEFAULT NULL, DROP lesson_id, DROP content_id');
        $this->addSql('ALTER TABLE lesson_content ADD CONSTRAINT FK_BB9620E394E8343 FOREIGN KEY (contents_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE lesson_content ADD CONSTRAINT FK_BB9620EFED07355 FOREIGN KEY (lessons_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_BB9620E394E8343 ON lesson_content (contents_id)');
        $this->addSql('CREATE INDEX IDX_BB9620EFED07355 ON lesson_content (lessons_id)');
    }
}
